<?php

namespace App\Http\Controllers\Projects;

use Inertia\Inertia;
use App\Models\Issue;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class IssueController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        return Inertia::render('Issues/IssuesIndex', [
            'issues' => Auth::user()->issues()->with('project')
                ->orderBy('resolved')
                ->orderBy('priority', 'desc')
                ->get(),
            'projects' => Auth::user()->projects()->get(),
            'filters' => [
                'search' => $request->only('search')
            ]


        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $issue = Issue::create([
            'description' => $request->description,
            'priority' => $request->priority,
            'project_id' => $request->project_id['id'],
            'user_id' => Auth::user()->id
        ]);

        $notification = new Notification;
        $notification->createNotification("Issue #" . $issue->id . " created.");

        return Redirect::back()->with($issue ? 'success' : 'error', $issue ? 'Issue created successfully!' : 'Error adding issue!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function show(Issue $issue)
    {
        return response()->json($issue->with('project')
            ->where('id', $issue->id)
            ->where('user_id', auth()->user()->id)
            ->with(['notes', 'uploads'])
            ->first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Issue $issue)
    {
        $status = $issue->update(
            $request->only(['description', 'priority', 'project_id'])
        );

        $notification = new Notification;
        $notification->createNotification("Issue #" . $issue->name . " updated.");

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Issue updated successfully!' : 'Error updating issue!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Issue $issue)
    {
        $status = $issue->delete();

        $notification = new Notification;
        $notification->createNotification("Issue '" . $issue->name . "' deleted.");

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Issue deleted successfully!' : 'Error deleting issue!'
        ]);
    }

    /**
     * Set an issue as complete.
     *
     * @param  int  $issue_id
     * @return \Illuminate\Http\Response
     */
    public function resolve(Issue $issue)
    {
        $issue->resolved = 1;
        $issue->resolved_date = date('Y-m-d');
        $status = $issue->save();

        $notification = new Notification;
        $notification->createNotification("Issue #" . $issue->id . " is resolved.");

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Issue is now resolved!' : 'Issue could not be resolved!'
        ]);
    }

    /**
     * Set an issue as incomplete.
     *
     * @param  int  $issue_id
     * @return \Illuminate\Http\Response
     */
    public function unresolve(Issue $issue)
    {
        $issue->resolved = 0;
        $issue->resolved_date = null;
        $status = $issue->save();

        $notification = new Notification;
        $notification->createNotification("Issue #" . $issue->id . " is unresolved.");

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Issue is now unresolved!' : 'Issue could not be marked as unresolved!'
        ]);
    }
}
