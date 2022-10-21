<?php
/*
|--------------------------------------------------------------------------
| UserTransformer.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for returning an array of user information that is
| that should not contain any sensitive information
*/

namespace App\Library\Transformer;


use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserTransformer extends AbstractTransformer
{
    /**
     * @param Model $model
     * @return array
     */
    public static function single(Model $model)
    {

        return [
            'id' => $model->id,
            'first_name' => $model->first_name,
            'last_name' => $model->last_name,
            'email'     => $model->email
        ];
    }
    /**
     * @param Model $model
     * @return array
     */
    public static function single_roles(Model $model)
    {
        $permissions = [];
        $roles = [];
        foreach ($model->roles as $role) {

            $roles[] = $role->name;

            foreach ($role->permissions as $permission) {

                $permissions[] = $permission->name;
            }
        }
        return $roles;
        // 'roles'     => $model->roles->pluck('name', 'permissions'),
    }
    /**
     * @param Model $model
     * @return array
     */
    public static function single_permissions(Model $model)
    {
        $permissions = [];
        $roles = [];
        foreach ($model->roles as $role) {

            $roles[] = $role->name;

            foreach ($role->permissions as $permission) {

                $permissions[] = $permission->name;
            }
        }
        return $permissions;
        // 'permissions'     => $model->roles->pluck('permissions')
        // 'username'  => $model->username
    }
}
