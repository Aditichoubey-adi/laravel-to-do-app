<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller; 

class TaskController extends Controller
{
    
    public function index(Request $request)
    {
       
        $filter = $request->query('filter', 'all');

       
        $tasks = Task::query();

        
        if ($filter === 'completed') {
            
            $tasks->where('is_completed', true);
        } elseif ($filter === 'pending') {
            
            $tasks->where('is_completed', false);
        }
        
       
        $tasks = $tasks->get(); 
        
      
        return view('tasks.index', compact('tasks', 'filter')); 
    }

    
    public function store(Request $request)
    {
       
        $validated = $request->validate([
            'title' => 'required|max:255',
        ]);
        
       
        Task::create([
            'title' => $validated['title'],
            'is_completed' => false, 
        ]);
        
       
        return redirect()->route('tasks.index');
    }

    
    public function toggle(Task $task)
    {
       
        $task->is_completed = ! $task->is_completed;
        $task->save();

       
        return back(); 
    }

    
    public function destroy(Task $task)
    {
       
        $task->delete();
        
        
        return back();
    }
}