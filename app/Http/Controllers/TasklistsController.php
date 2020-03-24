<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TasklistsController extends Controller
{
    public function index()
    {
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $tasklists = $user->tasklists()->orderBy('created_at', 'desc')->paginate(10);
            
            $data = [
                'user' => $user,
                'tasklists' => $tasklists,
            ];
        }
        
        return view('welcome', $data);
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:191',
        ]);

        $request->user()->tasklists()->create([
            'content' => $request->content,
        ]);

        return back();
    }
    
    public function destroy($id)
    {
        $tasklist = \App\Tasklist::find($id);

        if (\Auth::id() === $tasklist->user_id) {
            $tasklist->delete();
        }

        return back();
    }
    
    public function show($id)
    {
        $user = User::find($id);
        $tasklists = $user->tasklists()->orderBy('created_at', 'desc')->paginate(10);

        $data = [
            'user' => $user,
            'tasklists' => $tasklists,
        ];

        $data += $this->counts($user);

        return view('users.show', $data);
    }
}