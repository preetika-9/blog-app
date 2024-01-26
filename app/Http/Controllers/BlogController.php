<?php

namespace App\Http\Controllers;

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
    public function index()
    {
        $posts = Post::latest()->get();
        // $posts = Post::all();
        return view('blogPosts.blog', compact('posts'));
    }

    public function create()
    {
        return view('blogPosts.create-blog-post');
    }

    public function store(Request $request)
    {
        $request->validate(([
            'title' => 'required',
            'image' => 'required | image',
            'body' => 'required'
        ]));
        // dd('Validation passed');

        $title = $request->input('title');

        $postId = Post::latest()->take(1)->first()->id + 1;
        $slug = Str::slug($title, '-') . '-' . $postId; //The COding Book  === str slug converts into === the-coding-book
        $user_id = Auth::user()->id;
        $body = $request->input('body');

        // file upload
        $imagePath = 'storage/' .   $request->file('image')->store('postsImages', 'public');  //storage->app->public->postsImages->list of images     after this
        //in termilal  php artisan storage:link  --> copy of same folder in public->storage->postsImages->list of images
        // postsImages/Oi5waM1akopevp66xn0h9KjsSFVKvFf1nGPH5YHY.png

        $post = new Post(); //Post is model
        $post->title = $title;
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
        return view('blogPosts.single-blog-post', compact('post'));
    }

    public function delete(Post $post)
    {
        $post->delete();
        return redirect()->back()->with('status', 'Post Deleted Successfully');
    }
}
