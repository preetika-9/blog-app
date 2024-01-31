<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }
    public function index(Request $request)
    {
        // search
        if ($request->search) {
            $posts = Post::where('title', 'like', '%' . $request->search . '%')
                ->orWhere('body', 'like', '%' . $request->search . '%')->latest()->paginate(4);
            // last post   search = %ost%   
        } elseif ($request->category) {
            $posts = Category::where('name', $request->category)->firstOrFail()->posts()->paginate(3)->withQueryString();
        } else {
            $posts = Post::latest()->paginate(4);
        }


        // taking all the categories
        $categories = Category::all();
        // $posts = Post::all();
        return view('blogPosts.blog', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('blogPosts.create-blog-post', compact('categories'));
    }

    public function store(Request $request)
    {
        // dd($request->category_id);
        $request->validate(([
            'title' => 'required',
            'image' => 'required | image',
            'body' => 'required',
            'category_id' => 'required'
        ]));
        // dd('Validation passed');

        $title = $request->input('title');
        $category_id = $request->input('category_id');

        if (Post::latest()->first() !== null) {
            $postId = Post::latest()->first()->id + 1;
        } else {
            $postId = 1;
        }
        $slug = Str::slug($title, '-') . '-' . $postId; //The COding Book  === str slug converts into === the-coding-book
        $user_id = Auth::user()->id;
        $body = $request->input('body');

        // file upload
        $imagePath = 'storage/' .   $request->file('image')->store('postsImages', 'public');  //storage->app->public->postsImages->list of images     after this
        //in termilal  php artisan storage:link  --> copy of same folder in public->storage->postsImages->list of images
        // postsImages/Oi5waM1akopevp66xn0h9KjsSFVKvFf1nGPH5YHY.png

        $post = new Post(); //Post is model
        $post->title = $title;
        $post->category_id = $category_id;
        $post->slug = $slug;
        $post->user_id = $user_id;
        $post->body = $body;
        $post->imagePath = $imagePath;

        $post->save(); //after we save return to the same page
        return redirect()->back()->with('status', 'Post Created Successfully');
    }

    public function edit(Post $post)
    {
        if (auth()->user()->id !== $post->user->id) {
            abort(403);
        }
        return view('blogPosts.edit-blog-post', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        if (auth()->user()->id !== $post->user->id) {
            abort(403);
        }
        $request->validate(([
            'title' => 'required',
            'image' => 'required | image',
            'body' => 'required'
        ]));


        $title = $request->input('title');

        $postId = $post->id;
        $slug = Str::slug($title, '-') . '-' . $postId; //The COding Book  === str slug converts into === the-coding-book
        $body = $request->input('body');

        // file upload
        $imagePath = 'storage/' .   $request->file('image')->store('postsImages', 'public');  //storage->app->public->postsImages->list of images     after this
        //in termilal  php artisan storage:link  --> copy of same folder in public->storage->postsImages->list of images
        // postsImages/Oi5waM1akopevp66xn0h9KjsSFVKvFf1nGPH5YHY.png


        $post->title = $title;
        $post->slug = $slug;
        $post->body = $body;
        $post->imagePath = $imagePath;

        $post->save(); //after we save return to the same page
        return redirect()->back()->with('status', 'Post Edited Successfully');
    }



    // using route modle binding 
    public function show(Post $post)
    {
        $category = $post->category;

        $relatedPosts = $category->posts()->where('id', '!=', $post->id)->latest()->take(3)->get();
        return view('blogPosts.single-blog-post', compact('post', 'relatedPosts'));
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->back()->with('status', 'Post Deleted Successfully');
    }
}
