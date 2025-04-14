<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    function index()
    {
        $todos = Todo::where('user_id', auth()->id())->orderBy('count')->get();
        return inertia('todo/Index', compact('todos'));
    }
    function store(Request $request)
    {

        $data = $request->validate([
            'name' => 'required|min:2|max:255'
        ]);

        Todo::create([
            'name' => $data['name'],
            'user_id' => auth()->id(),
            'count' => Todo::where('user_id', auth()->id())->count()
        ]);

        // return back();
        return redirect(route('todo.index'));
    }

    function update(Todo $todo, Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:2|max:255'
        ]);
        Todo::where('id', $todo->id)->where('user_id', auth()->id())->update([
            'name' => $data['name']
        ]);
        // return back();
        return redirect(route('todo.index'));
    }

    function destroy(?Todo $todo = null)
    {
        if ($todo == null) {
            Todo::where("user_id", auth()->id())->delete();
        } else {
            Todo::where("id", $todo->id)->where("user_id", auth()->id())->delete();
        }
        // return back();
        return redirect(route('todo.index'));
    }
    function status(Todo $todo)
    {
        Todo::where("id", $todo->id)->where("user_id", auth()->id())->update([
            'status' => request('status') == '1'
        ]);
        return redirect(route('todo.index'));
    }

    function order()
    {
        foreach (request('ids') as $count => $id) {
            Todo::where('user_id', auth()->id())->where('id', $id)
                ->update(['count' => $count]);
        }
    }
}
