<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\Put;
use App\Http\Requests\Post\Store;
use App\Models\Category;
use App\Models\Post;

class PostController extends Controller
{


    public function index()
    {
        $posts = Post::paginate(2);
        return inertia("dashboard/post/Index", compact("posts"));
    }


    public function create()
    {
        $categories = Category::get();
        return inertia("dashboard/post/Save",compact('categories'));
    }


    public function store(Store $request)
    {
        Post::create($request->validated());
        return to_route('post.index')->with('message', "Created post successfully");
    }


    public function edit(Post $post)
    {
        $categories = Category::get();
        return inertia("dashboard/post/Save", compact('post','categories'));
    }


    public function update(Put $request, Post $post)
    {
        $post->update($request->validated());
        return redirect()->route('post.index')->with('message', "Updated post successfully");
    }


    public function destroy(Post $post)
    {
        $post->delete();
        return to_route('post.index')->with('message', "Deleted post successfully");
    }

}
