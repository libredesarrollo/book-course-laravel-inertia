<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PostController extends Controller
{
    function index()
    {
        // $posts = Post::paginate(15);
        $categories = Category::get();
        //$posts = Post::where('id', '>=', 1);

        //data
        $type = request('type');
        $category_id = request('category_id');
        $from = request('from');
        $to = request('to');
        $search = request('search');
        //data

        $posts = Post::when(request('search'), function (Builder $query, string $search) {
            $query->where(function ($query) use ($search) {
                $query->orWhere('id', 'like', "%" . $search . "%")
                    ->orWhere('title', 'like', "%" . $search . "%")
                    ->orWhere('description', 'like', "%" . $search . "%");
            })
                ->when(request('type'), function (Builder $query, string $type) {
                    $query->where('type', $type);
                })

                ->when(request('category_id'), function (Builder $query, string $category_id) {
                    $query->where('category_id', $category_id);
                })

                ->when(request('to'), function (Builder $query, string $to) {
                    $query->whereBetween('date', [
                        date(request("from")),
                        date($to)
                    ]);
                });
        })->with('category')
            ->paginate(15);


        return inertia(
            'Blog/Index',
            [
                'posts' => $posts,
                'categories' => $categories,
                'prop_type' => $type,
                'prop_category_id' => $category_id,
                'prop_from' => $from,
                'prop_to' => $to,
                'prop_search' => $search,
            ]
        );
    }
    function show(Post $post)
    {
        $post->category;
        return inertia('Blog/Show', compact('post'));
    }
}
