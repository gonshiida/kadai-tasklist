<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function index()
    {
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $tasks = $user->tasks()->get();
            
            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
        }
        
        return view('welcome', $data);
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:191',
        ]);

        $request->user()->tasks()->create([
            'content' => $request->content,
        ]);

        return back();
    }
    
    public function destroy($id)
    {
        $task = \App\Tasklist::find($id);

        if (\Auth::id() === $task->user_id) {
            $task->delete();
        }

        return back();
    }
    
    public function show($id)
    {
        $user = User::find($id);
        $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);

        $data = [
            'user' => $user,
            'tasks' => $tasks,
        ];

        $data += $this->counts($user);

        return view('users.show', $data);
    }
}