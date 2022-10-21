<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Config;
use Spatie\Honeypot\ProtectAgainstSpam;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');

        if (Config::get('comments.guest_commenting') == true) {
            $this->middleware('auth')->except('store');
            $this->middleware(ProtectAgainstSpam::class)->only('store');
        } else {
            $this->middleware('auth');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        // Merge guest rules, if any, with normal validation rules.
        Validator::make($request->all(), array_merge($guest_rules ?? [], [
            'commentable_type' => 'required|string',
            'commentable_id' => 'required|string|min:1',
            'message' => 'required|string'
        ]))->validate();

        $model = ucfirst($request->commentable_type)::findOrFail($request->commentable_id);

        $comment = new Comment;

        $comment->commenter()->associate(Auth::user());

        $comment->commentable()->associate($model);
        $comment->comment = $request->message;
        $comment->approved = TRUE;
        $comment->save();

        return Redirect::to(URL::previous() . '#comment-' . $comment->getKey());

        // $this->validate($request, [
        //     'comment' => 'required|min:3',
        // ]);
        // $blog = Blog::findOrfail($request->id);
        // $blogcooment = new BlogComment($request->all());
        // $blogcooment->name = auth()->user()->full_name;
        // $blogcooment->email = auth()->user()->email;
        // $blogcooment->comment = $request->comment;
        // $blogcooment->blog_id = $blog->id;
        // $blogcooment->user_id = auth()->user()->id;
        // $blogcooment->save();
        // return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        Gate::authorize('edit-comment', $comment);

        Validator::make($request->all(), [
            'message' => 'required|string'
        ])->validate();

        $comment->update([
            'comment' => $request->message
        ]);

        return Redirect::to(URL::previous() . '#comment-' . $comment->getKey());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        Gate::authorize('delete-comment', $comment);

        if (Config::get('comments.soft_deletes') == true) {
            $comment->delete();
        } else {
            $comment->forceDelete();
        }
        return abort(419);
        return Redirect::back();

        // $comment = BlogComment::findOrFail($id);
        // if (auth()->user()->id == $comment->user_id) {
        //     $comment->delete();
        //     return back();
        // }
        // return abort(419);
    }

    /**
     * Creates a reply "comment" to a comment.
     */
    public function reply(Request $request, Comment $comment)
    {
        Gate::authorize('reply-to-comment', $comment);

        Validator::make($request->all(), [
            'message' => 'required|string'
        ])->validate();

        $reply = new Comment;
        $reply->commenter()->associate(Auth::user());
        $reply->commentable()->associate($comment->commentable);
        $reply->parent()->associate($comment);
        $reply->comment = $request->message;
        $reply->approved = TRUE;
        $reply->save();

        return Redirect::to(URL::previous() . '#comment-' . $reply->getKey());
    }
}
