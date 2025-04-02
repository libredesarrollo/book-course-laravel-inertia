<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\Put;
use App\Http\Requests\Post\Store;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{


    public function index()
    {
        $posts = Post::where("id", ">=", 1);
        $categories = Category::get();
        $search = request('search');
        $from = request('from');
        $to = request('to');
        $type = request('type');
        $category_id = request('category_id');
        $posted = request('posted');


        if (request('type')) {
            $posts->where('type', request("type"));
        }

        if (request('category_id')) {
            $posts->where('category_id', request("category_id"));
        }

        if (request('posted')) {
            $posts->where('posted', request("posted"));
        }

        if (request('search')) {
            $posts->where(function ($query) {
                $query->orWhere("id", "like", "%" . request("search") . "%")
                    ->orWhere("title", "like", "%" . request("search") . "%")
                    ->orWhere("description", "like", "%" . request("search") . "%")
                ;
            });
        }

        $posts = $posts->with('category')->paginate(15);
        return inertia("dashboard/post/Index", ["posts" => $posts, "categories" => $categories,
        "prop_posted" => $posted, "prop_category_id" => $category_id, "prop_type" => $type, 
        "prop_from" => $from, "prop_to" => $to, "prop_search" => $search]);
    }


    public function create()
    {
        $categories = Category::get();
        return inertia("dashboard/post/Save", compact('categories'));
    }


    public function store(Store $request)
    {
        Post::create($request->validated());
        return to_route('post.index')->with('message', "Created post successfully");
    }


    public function edit(Post $post)
    {
        $categories = Category::get();
        return inertia("dashboard/post/Save", compact('post', 'categories'));
    }


    public function update(Put $request, Post $post)
    {

        $post->update($request->validated());
        return redirect()->route('post.index')->with('message', "Updated post successfully");
    }

    public function upload(Request $request, Post $post)
    {
        $request->validate(
            [
                'image' => 'required|mimes:jpg,jpeg,png,gif|max:10240'
            ]
        );
        Storage::disk("public_upload")->delete("image/post/" . $post->image);
        $data['image'] = $filename = time() . "." . $request['image']->extension();
        $request->image->move(public_path("image/post"), $filename);
        $post->update($data);
        return to_route('post.index')->with('message', "Upload image to post successfully");
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return to_route('post.index')->with('message', "Deleted post successfully");
    }
}
