<?php

namespace App\Http\Controllers\Projects;

use App\Models\Task;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Client;
use App\Models\Project;
use App\Models\Credential;
use App\Models\Projectuser;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Helpers\General\Helpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ProjectsController extends BaseController
{

    public function index(Request $request)
    {
        // $projects = Project::where('user_id', Auth::id())->get();





        // if ($projects) {
        //     foreach ($projects as $project) {
        //         $completedWeight = Project::find($project->id)->tasks()->where('state', '=', 'complete')->sum('weight');
        //         $totalWeight = Project::find($project->id)->tasks()->sum('weight');

        //         $project["completedWeight"] = $completedWeight;
        //         $project["totalWeight"] = $totalWeight;
        //     }
        // }


        return Inertia::render('Projects/ProjectsIndex', [
            'projects' => Auth::user()->projects()
                ->with('client')
                ->orderBy('complete')
                ->orderByRaw('ISNULL(due_date), due_date ASC')
                ->orderByRaw('ISNULL(completed_date), completed_date ASC')
                ->get()
                ->map(function ($project) {
                    $completedWeight = Project::find($project->id)->tasks()->where('complete', '=', 1)->sum('weight');
                    $totalWeight = Project::find($project->id)->tasks()->sum('weight');

                    $project["completedWeight"] = $completedWeight;
                    $project["totalWeight"] = $totalWeight;
                    return $project;
                }),
            'clients' => Auth::user()->clients()->get(),
            'filters' => [
                'search' => $request->only('search')
            ]
        ]);
    }

    // Returns the given project view
    public function show(Project $project)
    {
        $project =    $project->with([
            'client'
        ])
            ->where('id', $project->id)
            ->where('user_id', auth()->user()->id)
            ->with(['tasks', 'issues', 'uploads'])
            ->first();

        // Must be refactored as a filter
        if ($project->isOwner() == false && $project->isMember() == false) {
            return Redirect::back();
        }
        return Inertia::render('Projects/ProjectShow', [
            'project' => $project,
            'clients' => Auth::user()->clients()->get()
        ]);

        return  view('ins/projects/show')->with('pTitle', $project->name);
    }

    // Get all user projects
    public function getAllUserProjects()
    {

        $projects = Project::where('user_id', Auth::id())->get();

        if ($projects) {
            foreach ($projects as $project) {
                $completedWeight = Project::find($project->id)->tasks()->where('state', '=', 'complete')->sum('weight');
                $totalWeight = Project::find($project->id)->tasks()->sum('weight');

                $project["completedWeight"] = $completedWeight;
                $project["totalWeight"] = $totalWeight;
            }
        }

        return $projects->toArray();
    }

    // Get all projects that the Auth user is a member of
    public function getAllMemberProjects()
    {
        $sharedProjects = Projectuser::where('user_id', Auth::id())->select('project_id')->get();
        $project_ids = [];

        foreach ($sharedProjects as $project) {
            $project_ids[] = $project->project_id;
        }

        $sharedProjects = Project::whereIn('id', $project_ids)->get();

        if ($sharedProjects) {
            foreach ($sharedProjects as $project) {
                $completedWeight = Project::find($project->id)->tasks()->where('state', '=', 'complete')->sum('weight');
                $totalWeight = Project::find($project->id)->tasks()->sum('weight');

                $project["completedWeight"] = $completedWeight;
                $project["totalWeight"] = $totalWeight;
            }
        }
        return $this->setStatusCode(200)->makeResponse('Projects retrieved successfully', $sharedProjects);
    }

    //	Return the given project
    public function getProject($id)
    {
        if (!Project::find($id)) {
            return $this->setStatusCode(404)->makeResponse('The project was not found');
        }

        $project = Project::find($id);
        $project->tasks = Task::where('project_id', $id)->get();
        $project->credentials = Credential::where('project_id', $id)->get();

        return $this->setStatusCode(200)->makeResponse('Project was successfully found', $project);
    }

    // Insert the given project into the database
    public function storeProject(Request $request)
    {
        $project = $request->all();
        $project['user_id'] = 1;
        // dd( $request->user() );

        if (!$project || strlen(trim($project['name']))  == 0) {
            return $this->setStatusCode(406)->makeResponse('No information provided to create project');
        }

        // Input::merge(array('user_id' => Auth::id()));
        Project::create($project);
        $id = \DB::getPdo()->lastInsertId();

        return $this->setStatusCode(200)->makeResponse('Project created successfully', Project::find($id));
    }

    // Update the given project
    public function updateProject(Request $request, $id)
    {

        if ($request->get('name') === null || $request->get('name') === "") {
            return $this->setStatusCode(406)->makeResponse('The project needs a name');
        }

        if (!Project::find($id)) {
            return $this->setStatusCode(404)->makeResponse('Project not found');
        }

        $project = $request->all();
        unset($project['_method']);

        Project::find($id)->update($project);
        return $this->setStatusCode(200)->makeResponse('The project has been updated');
    }

    public function getOwner($id)
    {
        $owner_id = Project::whereId($id)->pluck('user_id');
        $owner = User::whereId($owner_id)->get();

        return $this->setStatusCode(200)->makeResponse('ok.', $owner[0]);
    }

    public function getMembers($id)
    {
        $members_id = Projectuser::where('project_id', $id)->lists('user_id');
        $members = [];

        foreach ($members_id as $id) {
            $member = User::whereId($id)->get();
            array_push($members, $member[0]);
        }

        return $this->setStatusCode(200)->makeResponse('ok.', $members);
    }
    // Invites a user to the given project.
    public function invite($project_id, $email)
    {
        if (trim(strlen($email)) == 0) {
            return $this->setStatusCode(406)->makeResponse('The email field is required!');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->setStatusCode(406)->makeResponse('Please enter a valid email!');
        }

        $project_name    = Project::find($project_id)->pluck('name');
        $owner_id        = Project::find($project_id)->pluck('user_id');
        $project_url     = url() . '/projects/' . $project_id;
        $invited_user   = User::whereEmail($email)->get();

        if (count($invited_user) == 0) {
            return $this->setStatusCode(406)->makeResponse('That user does not have an account.');
        }
        $invited_user = $invited_user[0];

        if (count(Projectuser::whereUserId($invited_user->id)->whereProjectId($project_id)->get()) != 0) {
            return $this->setStatusCode(406)->makeResponse('A user with that email has already been invited.');
        }

        if (Auth::id() != $owner_id) {
            return $this->setStatusCode(406)->makeResponse('Only the project owner can invite a user.');
        }
        // Save the relationship between user and project.
        $pu                =     new Projectuser();
        $pu->project_id    =    $project_id;
        $pu->user_id    =    $invited_user->id;
        $pu->save();

        Helpers::sendProjectInviteMail($email, $project_name, $project_url);
        return $this->setStatusCode(200)->makeResponse('A new member has been added to this project.', $invited_user);
    }

    // Removes a member from a given project
    public function removeMember($project_id, $member_id)
    {
        if (count(Projectuser::whereUserId($member_id)->whereProjectId($project_id)->get()) == 0) {
            return $this->setStatusCode(406)->makeResponse('That user is not in this project.');
        }

        $project = Project::find($project_id);
        $project->members()->detach($member_id);

        return $this->setStatusCode(200)->makeResponse('Member has been removed from this project.');
    }

    /**
     * Set a project as complete.
     *
     * @param  int  $project_id
     * @return \Illuminate\Http\Response
     */
    public function complete(Project $project)
    {
        $project->completed = 1;
        $project->completed_date = date('Y-m-d');
        $status = $project->save();

        $notification = new Notification;
        $notification->createNotification("Project '" . $project->name . "' completed.");

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Project is now complete!' : 'Project could not be completed!'
        ]);
    }

    /**
     * Set a project as incomplete.
     *
     * @param  int  $project_id
     * @return \Illuminate\Http\Response
     */
    public function incomplete(Project $project)
    {
        $project->completed = 0;
        $project->completed_date = null;
        $status = $project->save();

        $notification = new Notification;
        $notification->createNotification("Project '" . $project->name . "' incomplete.");

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Project is now incomplete!' : 'Project could not be marked as incomplete!'
        ]);
    }

    /**
     * Get a project's issues.
     *
     * @param  int  $project_id
     * @return \Illuminate\Http\Response
     */
    public function issues(Project $project)
    {
        return response()->json($project->issues()->get());
    }
}
