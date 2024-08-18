<?php

namespace App\Http\Controllers\Dashboard;


use App\Http\Controllers\Controller;
use App\Http\Requests\Post\Put;
use App\Http\Requests\Post\Store;
use App\Models\Category;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::paginate(2);
        return inertia('Dashboard/Post/Index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();

        return inertia("Dashboard/Post/Save", compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store $request)
    {
        Post::create($request->validated());
        return to_route('post.index')->with('message', 'Record Created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::get();
        return inertia('Dashboard/Post/Save', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Put $request, Post $post)
    {
        $post->update($request->validated());
        return to_route('post.index')->with('message', 'Record Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return to_route('post.index')->with('message', 'Record Deleled!');
    }
}
