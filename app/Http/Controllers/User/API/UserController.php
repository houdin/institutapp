<?php

namespace App\Http\Controllers\User\API;



use App\Library\Transformer\UserTransformer;
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;
use Request;
use Spatie\Permission\Models\Role;

class UserController extends AbstractUserAPIController
{
    /**
     * OrderController constructor.
     */
    function __construct()
    {
        $this->middleware('ajax.auth');
    }

    /**
     * returns the users information if logged in
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        //dd(UserTransformer::single(Auth::user()));
        if (Auth::check()) {
            try {
                $user = UserTransformer::single(Auth::user());
            } catch (\Exception $exception) {
                return $this->processingError();
            }

            return response()->json([
                'user' => $user
            ], 200);
        }
        return response()->json(false, 401);
    }
    /**
     * returns the users information if logged in
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function role($cn, $err = null)
    {

        // if (Auth::check() && Auth::user()->can($permission)) {

        //     return response()->json([
        //         'permission' => true
        //     ], 200);
        // }
        if (Auth::check()) {
            $role = Auth::user()->roles->pluck('ref')[0];

            if ($role == $cn) {
                return response()->json([
                    'role' => true
                ], 200);
            }
            // try {
            //     $roles = UserTransformer::single_roles(Auth::user()->load('roles.permissions'));
            // } catch (\Exception $exception) {
            //     return $this->processingError();
            // }

        }
        if ((int)$err == 1) {
            return response()->json(false, 401);
        } else {
            return response()->json(false);
        }
        return abort(401);
    }
    /**
     * returns the users information if logged in
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function check()
    {
        if (Auth::check()) {

            return response()->json([
                'check' => true
            ], 200);
        }
        return response()->json(false, 401);

        return abort(401);
    }
    /**
     * returns the users information if logged in
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function permission($cn, $err = null)
    {


        // $permission = Permission::getPermissions(['ref' => request()->cn]);
        $permission = Permission::getPermissions(['ref' => $cn])->pluck('name')[0];

        if (Auth::check() && Auth::user()->can($permission)) {
            // try {
            //     $permissions = UserTransformer::single_permissions(Auth::user()->load('roles.permissions'));
            // } catch (\Exception $exception) {
            //     return $this->processingError();
            // }
            return response()->json(['permission' => true], 200);
        }
        if ((int)$err == 1) {
            return response()->json(false, 401);
        } else {
            return response()->json(false);
        }
    }
}
