<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CartController extends Controller
{
    function add(Post $post, int $count)
    {
        $cart = session('cart', []);

        // delete
        if ($count <= 0) {
            if (Arr::exists($cart, $post->id)) {
                unset($cart[$post->id]);
                session(['cart' => $cart]);
                $this->saveDB($cart);
            }
            return redirect()->back();
        }


        // add
        if (Arr::exists($cart, $post->id)) {
            // update
            $cart[$post->id][1] = $count;
        } else {
            // add
            $cart[$post->id] = [$post, $count];
        }

        session(['cart' => $cart]);
        $this->saveDB($cart);
        return redirect()->back();
    }

    private function saveDB($cart)
    {
        if (auth()->check()) {

            $control = time();

            foreach ($cart as $c) {
                if (Post::find($c[0]->id) != null) {
                    ShoppingCart::updateOrCreate(
                        [
                            'post_id' => $c[0]->id,
                            'user_id' => auth()->id(),
                        ],
                        [
                            'post_id' => $c[0]->id,
                            'count' => $c[1],
                            'user_id' => auth()->id(),
                            'control' => $control
                        ]
                    );
                }
            }

            ShoppingCart::whereNot('control', $control)->where('user_id', auth()->id())->delete();
        }
    }

    function index()
    {
        return inertia('shop/Index');
    }
}
