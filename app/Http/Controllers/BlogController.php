<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BlogController extends Controller
{

    private $path;

    public function __construct()
    {
    }


    public function getByCategory(Request $request)
    {
        $popular_tags = Tag::has('blogs', '>', 4)->get();

        $category = Category::where('slug', '=', Str::slug($request->category))->first();
        $categories = Category::has('blogs')->where('status', '=', 1)->OrderBy('id', 'desc')->paginate(10);
        if ($category != "") {
            $blogs = $category->blogs()->paginate(6);
            if (request()->ajax() || request()->api == true) {
                return response()->json([
                    'category' => $category,
                    'blogs' => $blogs,
                    'categories' => $categories,
                    'popular_tags' => $popular_tags
                ]);
            }
            return view('frontend.blogs.index', compact('category', 'blogs', 'popular_tags', 'categories'));
        }
        if (request()->ajax() || request()->api == true) {
            return response()->json([], 404);
        }
        return abort(404);
    }

    public function getIndex()
    {
        $popular_tags = Tag::has('blogs', '>', 4)->get();
        $categories = Category::has('blogs')->where('status', '=', 1)
            ->take(10)->get();


        $blogs = Blog::has('category')->with(['image'])->OrderBy('id', 'desc')->paginate(10);

        // if (request()->ajax() || request()->api == true) {
        //     return response()->json([
        //         'blogs' => $blogs,
        //         'categories' => $categories,
        //         'popular_tags' => $popular_tags
        //     ]);
        // }

        return Inertia::render('Institut/Blog/BlogIndex', [
            'blogs' => $blogs,
            'categories' => $categories,
            'popular_tags' => $popular_tags
        ]);
        // return view(
        //     'frontend.blogs.index',
        //     compact('blogs', 'categories', 'popular_tags')
        // );
    }

    public function show($slug)
    {
        $popular_tags = Tag::has('blogs', '>', 4)->get();
        $categories = Category::has('blogs')->where('status', '=', 1)
            ->take(10)->get();

        $blog = Blog::where('slug', $slug)->firstOrFail();
        // get previous user id
        $previous_id = Blog::where('id', '<', $blog->id)->max('id');
        $previous = Blog::find($previous_id);

        // get next user id
        $next_id = Blog::where('id', '>', $blog->id)->min('id');
        $next = Blog::find($next_id);

        $related_news = $blog->category->blogs()->where('id', '!=', $blog->id)->take(2)->get();

        if (request()->ajax() || request()->api == true) {
            return response()->json([
                'blog' => $blog,
                'previous' => $previous,
                'next' => $next,
                'popular_tags' => $popular_tags,
                'categories' => $categories,
                'related_news' => $related_news
            ]);
        }



        // return view(
        //     'frontend.blogs.index',
        //     compact('blogs', 'categories', 'popular_tags')
        // );
    }

    public function getByTag(Request $request)
    {
        $popular_tags = Tag::has('blogs', '>', 4)->get();
        $tag = Tag::where('slug', '=', Str::slug($request->tag))->first();
        $categories = Category::has('blogs')->where('status', '=', 1)->paginate(10);
        if ($tag != "") {
            $blogs = $tag->blogs()->paginate(6);

            if (request()->ajax() || request()->api == true) {
                return response()->json([
                    'tag' => $tag,
                    'blogs' => $blogs,
                    'categories' => $categories,
                    'popular_tags' => $popular_tags
                ]);
            }
            // return view('frontend.blogs.index', compact('tag', 'blogs', 'categories', 'popular_tags'));
        }
        if (request()->ajax() || request()->api == true) {
            return response()->json([], 404);
        }

        return abort(404);
    }

    public function storeComment(Request $request)
    {


        $this->validate($request, [
            'comment' => 'required|min:3',
        ]);
        $blog = Blog::findOrfail($request->id);
        $blogcooment = new Comment($request->all());
        $blogcooment->name = auth()->user()->full_name;
        $blogcooment->email = auth()->user()->email;
        $blogcooment->comment = $request->comment;
        $blogcooment->blog_id = $blog->id;
        $blogcooment->user_id = auth()->user()->id;
        $blogcooment->save();
        return back();
    }

    public function deleteComment($id)
    {
        // $comment = BlogComment::findOrFail($id);
        // if(auth()->user()->id == $comment->user_id){
        //     $comment->delete();
        //     return back();
        // }
        // return abort(419);
    }
}
