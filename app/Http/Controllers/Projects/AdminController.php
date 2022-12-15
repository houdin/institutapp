<?php

namespace App\Http\Controllers\Projects;



use App\Models\Task;

use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;

class AdminController extends BaseController
{

    /**
     * Takes you to the admin page of the app
     * @return mixed
     */
    public function index()
    {
        if (Auth::user()->email != env('ADMIN_EMAIL')) {
            return Redirect::back();
        }

        $users = User::all();
        $n_users = count($users);
        $n_tasks = Task::all()->count();
        $n_projects = Project::all()->count();
        $n_clients = Client::all()->count();

        return View::make('admin/index')
            ->with('pTitle', 'Admin')
            ->with('users', $users)
            ->with('n_users', $n_users)
            ->with('n_tasks', $n_tasks)
            ->with('n_projects', $n_projects)
            ->with('n_clients', $n_clients);
    }
}
