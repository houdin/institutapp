<?php

namespace App\Models\Auth;

use App\Models\Issue;
use App\Models\Media;
use App\Models\Order;
use App\Models\Module;
use App\Models\Address;
use App\Models\Earning;
use App\Models\Invoice;
use App\Models\Withdraw;
use App\Models\Formation;
use App\Models\OrderItem;
// use App\Models\Traits\Uuid;
use App\Models\Certificate;
use App\Models\Notification;
use App\Models\VideoProgress;
use App\Models\ChapterStudent;
use App\Models\TeacherProfile;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\HasTeams;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Laravel\Passport\HasApiTokens;
use App\Models\Auth\Traits\Commenter;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
// use Gerardojbaez\Messenger\Traits\Messageable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use App\Models\Auth\Traits\Scope\UserScope;
use App\Models\Auth\Traits\Method\UserMethod;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Auth\Traits\SendUserPasswordReset;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Auth\Traits\Attribute\UserAttribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Auth\Traits\Relationship\UserRelationship;


// use Gerardojbaez\Messenger\Contracts\MessageableInterface;


/**
 * Class User.
 */
// class User extends Authenticatable implements MessageableInterface, MustVerifyEmail
class User extends Authenticatable implements MustVerifyEmail
{
    use HasRoles,
        Notifiable,
        SendUserPasswordReset,
        SoftDeletes,
        UserAttribute,
        UserMethod,
        UserRelationship,
        UserScope,
        // Messageable,
        Commenter;
    use HasApiTokens;

    use HasUuids;

    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use TwoFactorAuthenticatable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'dob',
        'phone',
        'gender',
        'address',
        'city',
        'pincode',
        'profile_photo_path',
        'state',
        'country',
        'avatar_type',
        'avatar_location',
        'password',
        'password_changed_at',
        'active',
        'confirmation_code',
        'confirmed',
        'timezone',
        'last_login_at',
        'last_login_ip',
        'fb_id',
        'google_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
        'pivot'
    ];

    /**
     * @var array
     */
    protected $dates = ['last_login_at', 'deleted_at'];

    /**
     * The dynamic attributes from mutators that should be returned with the user object.
     * @var array
     */
    protected $appends = ['profile_photo_url'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
        'confirmed' => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    // protected static function newFactory()
    // {
    //     return UserFactory::new();
    // }

    public function name(): Attribute
    {
        return Attribute::get(fn ($value) => $value);
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'module_student');
    }

    public function chapters()
    {
        return $this->hasMany(ChapterStudent::class, 'user_id');
    }

    public function formations()
    {
        return $this->belongsToMany(Formation::class, 'formation_user');
    }


    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }


    public function getImageAttribute()
    {
        return $this->picture;
    }


    //Calc Watch Time
    public function getWatchTime()
    {
        $watch_time = VideoProgress::where('user_id', '=', $this->id)->sum('progress');
        return $watch_time;
    }

    //Check Participation Percentage
    public function getParticipationPercentage()
    {
        $videos = Media::featured()->where('status', '!=', 0)->get();
        $count = $videos->count();
        $total_percentage = 0;
        if ($count > 0) {
            foreach ($videos as $video) {
                $total_percentage = $total_percentage + $video->getProgressPercentage($this->id);
            }
            $percentage = $total_percentage / $count;
        } else {
            $percentage = 0;
        }
        return round($percentage, 2);
    }

    //Get Certificates
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function pendingOrders()
    {
        $orders = Order::where('status', '=', 0)
            ->where('user_id', '=', $this->id)
            ->get();

        return $orders;
    }

    public function purchasedFormations()
    {
        $orders = Order::where('status', '=', 1)
            ->where('user_id', '=', $this->id)
            ->pluck('id');
        $formations_id = OrderItem::whereIn('order_id', $orders)
            ->where('item_type', '=', "App\Models\Formation")
            ->pluck('item_id');
        $formations = Formation::whereIn('id', $formations_id)
            ->get();
        return $formations;
    }


    public function purchases()
    {
        $orders = Order::where('status', '=', 1)
            ->where('user_id', '=', $this->id)
            ->pluck('id');
        $formations_id = OrderItem::whereIn('order_id', $orders)
            ->pluck('item_id');
        $purchases = Formation::where('published', '=', 1)
            ->whereIn('id', $formations_id)
            ->get();
        return $purchases;
    }

    public function findForPassport($user)
    {
        $user = $this->where('email', $user)->first();
        if ($user->hasRole('student')) {
            return $user;
        }
    }

    /**
     * Get the teacher profile that owns the user.
     */
    public function teacherProfile()
    {
        return $this->hasOne(TeacherProfile::class);
    }

    /**
     * Get the earning owns the teacher.
     */
    public function earnings()
    {
        return $this->hasMany(Earning::class, 'user_id', 'id');
    }

    /**
     * Get the withdraw owns the teacher.
     */
    public function withdraws()
    {
        return $this->hasMany(Withdraw::class, 'user_id', 'id');
    }


    ////////// ECOMMERCE
    /**
     * returns all the users addresses
     *
     * @param $query
     * @param $id
     * @return $this
     */
    public function scopeUserAddresses($query, $id)
    {
        return $query->find($id)
            ->addresses()
            ->with('state')
            ->get();
    }


    /**
     * A user has many addresses
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * A user has many orders
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * Get the columns that should receive a unique identifier.
     *
     * @return array
     */
    public function uniqueIds()
    {
        return ['uuid'];
    }

    /**
     * Update the user's profile photo.
     *
     * @param  \Illuminate\Http\UploadedFile  $photo
     * @return void
     */
    public function updateProfilePhoto(UploadedFile $photo)
    {
        tap($this->profile_photo_path, function ($previous) use ($photo) {
            $this->forceFill([
                'profile_photo_path' => $photo->storePublicly(
                    'profile-photos',
                    ['disk' => $this->profilePhotoDisk()]
                ),
            ])->save();

            if ($previous) {
                Storage::disk($this->profilePhotoDisk())->delete($previous);
            }
        });
    }

    /**
     * Get the default profile photo URL if no profile photo has been uploaded.
     *
     * @return string
     */
    protected function defaultProfilePhotoUrl()
    {
        $name = trim(collect(explode(' ', $this->name))->map(function ($segment) {
            return mb_substr($segment, 0, 1);
        })->join(' '));

        return 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Delete the user's profile photo.
     *
     * @return void
     */
    public function deleteProfilePhoto()
    {
        if (!Features::managesProfilePhotos()) {
            return;
        }

        if (is_null($this->profile_photo_path)) {
            return;
        }

        Storage::disk($this->profilePhotoDisk())->delete($this->profile_photo_path);

        $this->forceFill([
            'profile_photo_path' => null,
        ])->save();
    }

    /**
     * Return the related clients for a given user
     */
    public function clients()
    {
        return $this->hasMany('App\Models\Client', 'user_id');
    }

    /**
     * Return the related projects for a given user
     */
    public function projects()
    {
        return $this->hasMany('App\Models\Project', 'user_id');
    }

    /**
     * Return the related tasks for a given user
     */
    public function tasks()
    {
        return $this->hasMany('App\Models\Task', 'user_id');
    }

    public function issues()
    {
        return $this->hasMany(Issue::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function inProjects()
    {
        return $this->belongsToMany('App\Models\Project');
    }

    /**
     * Get the total weight of a user
     * @param  [int] $id [the id of the user]
     * @return [int]     [the total weight of all the incomplete tasks a user has]
     */
    public static function weight($id = null)
    {
        if ($id == null) {
            $result = \DB::table('tasks')->where('user_id', \Auth::id())->whereState('incomplete')->sum('weight');
        } else {
            $result = \DB::table('tasks')->where('user_id', $id)->whereState('incomplete')->sum('weight');
        }
        return $result;
    }

    // /**
    //  * User can have one role
    //  *
    //  * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    //  */
    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class);
    // }

    // /**
    //  * Check if a user has a particular role
    //  *
    //  * @param $name
    //  * @return bool
    //  */
    // public function hasRole($name)
    // {
    //     foreach ($this->roles as $role)
    //     {

    //         if ($role->name == $name) return true;
    //     }
    //     return false;
    // }

    // /**
    //  * Check if user has a role
    //  *
    //  * @return bool
    //  */
    // public function hasNoRole()
    // {
    //     if(empty($this->roles->first()->name))
    //     {
    //         return true;
    //     }

    //     return false;
    // }

    // /**
    //  * Assigns a role to a user
    //  *
    //  * @param $role
    //  * @return void
    //  */
    // public function assignRole(Role $role)
    // {
    //     $this->roles()->attach($role->id);
    // }


    // /**
    //  * Removes a role from a user
    //  *
    //  * @param  Role $role
    //  * @return void
    //  */
    // public function removeRole(Role $role)
    // {
    //     $this->roles()->detach($role);
    // }

    /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     *
     * @param string $email The email address
     * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
     * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
     * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
     * @param boole $img True to return a complete IMG tag False for just the URL
     * @param array $atts Optional, additional key/value attributes to include in the IMG tag
     * @return String containing either just a URL or a complete image tag
     * @source http://gravatar.com/site/implement/images/php/
     */
    public static function get_gravatar($email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array())
    {
        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r";
        if ($img) {
            $url = '<img src="' . $url . '"';
            foreach ($atts as $key => $val)
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }
        return $url;
    }
}
