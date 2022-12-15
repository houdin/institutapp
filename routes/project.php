<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Projects\IssueController;
use App\Http\Controllers\Projects\TasksController;
use App\Http\Controllers\Projects\UploadController;
use App\Http\Controllers\Projects\ClientsController;
use App\Http\Controllers\Projects\PremiumController;
use App\Http\Controllers\Projects\ProjectsController;
use App\Http\Controllers\Projects\SolutionController;
use App\Http\Controllers\Projects\IssueNoteController;
use App\Http\Controllers\Projects\CredentialsController;
use App\Http\Controllers\Projects\ProjectTaskController;



// Route::get('register', function(){ return View::make('register')->with('pTitle', "Register"); })->name('register');
// Route::get('login', function(){ return View::make('login')->with('pTitle', "Login"); })->name('login');
Route::get('faq', fn () => view('faq')->with('pTitle', "FAQ"))->name('faq');

//============Premium Routes=================//
// Route::get('premium', [PremiumController::class, 'index'])->name('premium');
Route::get('/tarifs', [PremiumController::class, 'index'])->name('pricing.index');


Route::get('solutions/{solution}', [SolutionController::class, 'solution'])->name('solution.description');

//----------------- Auth routes
Route::group(['middleware' => 'auth'], function () {

    Route::get('/hud', [HomeController::class, 'hud'])->name('hud');


    // Route::get('search', [HomeController::class, 'search'])->name('search');
    // Route::get('profile', [UserController::class, 'index'])->name('profile');

    // Route::get('clients', [ClientsController::class, 'index'])->name('clients');
    // Route::delete('clients/{id}', [ClientsController::class, 'destroy']);

    // USER
    // Route::resource('user', UserController::class);

    // Users - Associated
    Route::get('/users/clients', [UserController::class, 'clients']);
    Route::get('/users/projects', [UserController::class, 'projects']);
    Route::get('/users/issues', [UserController::class, 'issues']);

    Route::get('/settings', [UserController::class, 'index'])->name('settings');


    // CLIENT
    Route::resource('clients', ClientsController::class);
    Route::get('clients/{withWeight?}', [ClientsController::class, 'getAllUserClients']);
    // Route::get('clients/{withWeight?}', [ClientsController::class, 'getAllUserClients']);
    // Route::prefix('/client')->group(function () {
    //     Route::post('/', [ClientsController::class, 'storeClient']);
    //     Route::put('/{id}', [ClientsController::class, 'updateClient']);
    //     Route::delete('/{id}', [ClientsController::class, 'removeClient']);
    // });

    // PROJECT
    Route::resource('projects', ProjectsController::class);
    // Route::resource('projects', [ProjectsController::class, 'getAllUserProjects']);
    Route::prefix('/projects')->group(function () {
        Route::get('/shared', [ProjectsController::class, 'getAllMemberProjects']);
        Route::get('/{project}/owner', [ProjectsController::class, 'getOwner']);
        Route::get('/{project}/members', [ProjectsController::class, 'getMembers']);
        Route::post('/{project}/{email}/invite', [ProjectsController::class, 'invite']);
        Route::delete('/{project/{member_id}/remove', [ProjectsController::class, 'removeMember']);
        Route::post('/{project}/complete', [ProjectsController::class, 'complete']);
        Route::post('/{project}/incomplete', [ProjectsController::class, 'incomplete']);
    });

    // SOLUTION
    // Route::resource('projects', [ProjectsController::class, 'getAllUserProjects']);
    Route::prefix('/solutions')->group(function () {

        Route::get('/{project}/solutions', [SolutionController::class, 'SolutionsProject'])->name('solution.description');
        Route::get('/{project}/{solution}/taks', [SolutionController::class, 'solutionTaks'])->name('solution.taks');
        Route::delete('/{project/{solution}/remove', [SolutionController::class, 'deleteProjectSolution'])->name('solution.project.delete');
        Route::post('/{project}/{solution}/complete', [SolutionController::class, 'complete'])->name('solution.project.complete.update');
        Route::post('/{project}/{solution}/incomplete', [SolutionController::class, 'incomplete'])->name('solution.project.incomplete.update');
    });


    // TASK

    Route::resource('tasks', TasksController::class);
    // Route::get('tasks', [TasksController::class, 'getAllUserOpenTasks']);
    Route::prefix('/tasks')->group(function () {
        Route::post('/{client_id}/{project_id}', [TasksController::class, 'storeTask']);
        Route::post('/{project}/complete/{task}', [ProjectTaskController::class, 'complete']);
        Route::post('/{project}/incomplete/{task}', [ProjectTaskController::class, 'incomplete']);
        // Route::delete('/{id}', [TasksController::class, 'removeTask']);
        // Route::put('/{id}', [TasksController::class, 'updateTask']);
    });

    // Issues
    Route::resource('/issues', IssueController::class);
    Route::prefix('/issues')->group(function () {
        Route::post('/{issue}/resolve', [IssueController::class, 'resolve']);
        Route::post('/{issue}/unresolve', [IssueController::class, 'unresolve']);
    });

    // Issues - Notes
    Route::get('/notes/{issue}', [IssueNoteController::class, 'index']);
    Route::resource('/notes', IssueNoteController::class);


    // Notifications
    Route::get('/notifications', [HomeController::class, 'notifications'])->name('notifications');

    // Uploads
    Route::prefix('uploads')->group(function () {
        Route::get('/projects/{project}', [UploadController::class, 'getProjectUploads']);
        Route::get('/issues/{issue}', [UploadController::class, 'getIssueUploads']);
        Route::get('/clients/{client}', [UploadController::class, 'getClientUploads']);
        Route::post('/projects/{project}', [UploadController::class, 'storeProjectUpload']);
        Route::post('/issues/{issue}', [UploadController::class, 'storeIssueUpload']);
        Route::post('/clients/{client}', [UploadController::class, 'storeClientUpload']);

        Route::delete('/uploads/{upload}', [UploadController::class, 'destroy']);
    });



    // CREDENTIALS
    Route::get('credentials/{id}', [CredentialsController::class, 'getProjectCredentials']);
    Route::post('credentials', [CredentialsController::class, 'storeCredential']);
    Route::put('credentials/{id}', [CredentialsController::class, 'updateCredential']);



    // Route::resource('projects', ProjectsController::class)->only(['show']);;


    //	Route::delete('projects/{id}/remove', array('uses' => [ProjectsController::class , 'remove'], 'as' => 'projects.remove') );
    //    Route::get('projects/{id}/files', array('uses' => [ProjectsController::class , 'files'], 'as' => 'projects.files' ));
    //    Route::post('projects/{id}/files', array('uses' => [FilesController::class , 'store'], 'as' => 'files.store' ));
    //    Route::delete('projects/{id}/files', array('uses' => [FilesController::class , 'destroy'], 'as' => 'files.remove' ));
});
