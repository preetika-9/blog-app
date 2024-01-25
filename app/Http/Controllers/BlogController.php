<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::all();
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
        $slug = Str::slug($title, '-'); //The COding Book  === str slug converts into === the-coding-book
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

    public function show($slug)
    {
        // dd($slug);
        $post = Post::where('slug', $slug)->first();
        return view('blogPosts.single-blog-post', compact('post'));
    }
}
