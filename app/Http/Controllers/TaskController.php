<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::latest()->get();
        return view('todo',compact('tasks'));
    }

    public function store(Request $request)
    {
        // return request('taskText');
        $this->validate(request(),[
            'taskText' => 'string|max:255'
        ]);
        
        Task::create([
            'name' => request('taskText'),
        ]);

        return response(array('status' => 'success'));

    }

    public function update(Request $request)
    {
        $this->validate(request(),
        [
            'editedTask' => 'string|max:255'
        ]);
        $task = Task::find(request('taskID'));
        $task->name = request('editedTask');
        $task->save();

        return response(array('status' => 'success'));
        
    }

    public function done(Request $request)
    {
        $this->validate(
            request(),
            [
                'taskID' => 'integer'
            ]
        );
        $task = Task::find(request('taskID'));
        $task->done = 1;
        $task->save();

        return response(array('status' => 'success'));

    }

    public function undo(Request $request)
    {
        $this->validate(
            request(),
            [
                'taskID' => 'integer'
            ]
        );
        
        $task = Task::find(request('taskID'));
        $task->done = 0;
        $task->save();

        return response(array('status' => 'success'));

    }

    public function delete(Request $request)
    {
        $this->validate(request(),
            [
                'taskID' => 'integer'
            ]
        );
        Task::find(request('taskID'))->delete();

        return response(array('status' => 'success'));

    }

}
