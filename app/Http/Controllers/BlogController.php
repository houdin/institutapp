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

    public function index()
    {
        $popular_tags = Tag::has('blogs', '>', 4)->get();
        $categories = Category::has('blogs')->where('status', '=', 1)->get();


        $blogs = Blog::OrderBy('id', 'desc')->with(['image', 'categories', 'tags', 'comments'])->paginate(9);

        // if (request()->ajax() || request()->api == true) {
        //     return response()->json([
        //         'blogs' => $blogs,
        //         'categories' => $categories,
        //         'popular_tags' => $popular_tags
        //     ]);
        // }

        return Inertia::render('Blog/BlogIndex', [
            'articles' => $blogs,
            'categories' => $categories,
            'popular_tags' => $popular_tags,

            'enterClass' => "animate__animated animate__fadeInLeft",
            'leaveClass' => "animate__animated animate__fadeOutRight",

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

        $blog = Blog::where('slug', $slug)->with(['image', 'tags', 'categories', 'comments'])->firstOrFail();
        // get previous user id
        $previous = Blog::where('id', '<', $blog->id)->orderBy('id', 'desc')->first();

        // get next user id
        $next = Blog::where('id', '>', $blog->id)->orderBy('id')->first();


        // $related_news = $blog->category->blogs()->where('id', '!=', $blog->id)->take(2)->get();

        return Inertia::render('Blog/BlogShow', [
            'blog' => $blog,
            'previous' => $previous,
            'next' => $next,
            'popular_tags' => $popular_tags,
            'categories' => $categories,

            'enterClass' => "animate__animated animate__fadeInRight",
            'leaveClass' => "animate__animated animate__fadeOutLeft",
            // 'related_news' => $related_news
        ]);

        // if (request()->ajax() || request()->api == true) {
        //     return response()->json([
        //         'blog' => $blog,
        //         'previous' => $previous,
        //         'next' => $next,
        //         'popular_tags' => $popular_tags,
        //         'categories' => $categories,
        //         'related_news' => $related_news
        //     ]);
        // }



        // return view(
        //     'frontend.blogs.index',
        //     compact('blogs', 'categories', 'popular_tags')
        // );
    }

    public function getByTag(Request $request)
    {
        $popular_tags = Tag::has('blogs', '>', 4)->get();
        $tag = Tag::where('slug', '=', Str::slug($request->tag))->first();
        // $categories = Category::has('blogs')->where('status', '=', 1)->paginate(10);
        if ($tag != "") {
            $blogs = $tag->blogs()->paginate(6);

            if (request()->ajax() || request()->api == true) {
                return response()->json([
                    'tag' => $tag,
                    'blogs' => $blogs,
                    // 'categories' => $categories,
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
