<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    private $tasks;

    public function __construct()
    {

    }
    public function home(){
        $tasks = Task::where('user_id', auth()->id())->get();
        $complitedtask = $tasks ->where('status', Task::STATUS_COMPLETED)->count();
        $uncomplitedtask = $tasks ->whereNotIn('status', Task::STATUS_COMPLETED)->count();

        return view('home', ['sudahselesai'=>$complitedtask, 
    'belumselesai'=> $uncomplitedtask
    ]);
    }

    public function index()
    {
        $pageTitle = 'Task List';
        if(!Gate::allows('viewAnyTask', Task::class)) {
            $tasks = Task::where('user_id', Auth::id())->get();
        } else{
            $tasks = Task::all();
        }
        // dd($tasks);
        return view('tasks.index', [
            'pageTitle' => $pageTitle,
            'tasks' => $tasks
        ]);
    }
    public function edit($id, Request $request)
    {
        
        $pageTitle = 'Edit Task';
        $task = Task::find($id);
        if(Gate::allows('performAsTaskOwner', $task)||Gate::allows('updateAnyTask', Task::class)) {
        } else{
            return redirect()->route('home');
        }

        if($request->has('edittasksprogress')&& $request->edittasksprogress== 'task.progress'){
            return redirect()->route('tasks.progress');
        }

        return view('tasks.edit', ['pageTitle' => $pageTitle, 'task' => $task]);
    }

    public function create()
    {
        $pageTitle = 'create Task';

        return view('tasks.create', ['pageTitle' => $pageTitle, ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate(
            [
                'name' => 'required',
                'due_date' => 'required',
                'status' => 'required',
            ],
            $request->all()
        );
        Task::create([
        'name' => $request->name,
        'detail' => $request->detail,
        'due_date' => $request->due_date,
        'status' => $request->status,
        'user_id' =>Auth::user()->id,
     ]);
     return redirect()->route('tasks.index');
    }

    public function update(Request $request, $id){
        // dd($request->all());
        $request->validate(
            [
                'name' => 'required',
                'due_date' => 'required',
                'status' => 'required',
            ],
            $request->all()
        );
        $task = Task::find($id); 

        // $task->name = 'Belajar Eloquent';
        // $task->save();

        Gate::authorize('update', $task);

        $task->update([
            'name' => $request->name,
            'detail' => $request->detail,
            'due_date' => $request->due_date,
            'status' => $request->status,
        ]);
        return redirect()->route('tasks.index');

    }


    public function delete($id)
    {
        $pageTitle = 'Delete Task';
        $task = Task::find($id);
        if(Gate::allows('performAsTaskOwner', $task)||Gate::allows('deleteAnyTask', Task::class)) {
        } else{
            return redirect()->route('home');
        }
        // Gate::authorize('delete', $task);

        return view('tasks.delete', ['pageTitle' => $pageTitle, 'task' => $task]);


    }

    public function destroy($id)
    {
        $task = Task::find($id);
        Gate::authorize('delete', $task);

        $task->delete();
        return redirect()->route('tasks.index');
    }

    public function progres() 
    {
        $title = 'Task Progres';
        if(!Gate::allows('viewAnyTask', Task::class)) {
            $semuatask = Task::where('user_id', Auth::id())->get();
        } else{
        $semuatask = Task::all();
    }
        $tasktertentu = $semuatask->groupBy('status');
        $tasks = [
            Task::STATUS_NOT_STARTED => $tasktertentu -> get(Task::STATUS_NOT_STARTED, []),
            Task::STATUS_IN_PROGRESS=> $tasktertentu -> get(Task::STATUS_IN_PROGRESS, []),
            Task::STATUS_COMPLETED=> $tasktertentu -> get(Task::STATUS_COMPLETED, []),
            Task::STATUS_IN_REVIEW=> $tasktertentu -> get(Task::STATUS_IN_REVIEW, []),
        ];
    
        return view('tasks.progress', [
            'pageTitle' => $title, 
            'tasks' => $tasks
        ]);
    }


    public function move(int $id, Request $request)
{
    $task = Task::findOrFail($id);

    // Gate::authorize('move', $task);
    if (Gate::allows('performAsTaskOwner', $task)||Gate::allows('updateAnyTask', Task::class)) {
        
    } else{
        return redirect()->route('home');
    }


    $task->update([
        'status' => $request->status,
    ]);
    if($request->has('movetasklist')&& $request->movetasklist== 'task.list'){
        return redirect()->route('tasks.index');
    }

    return redirect()->route('tasks.progress');
}



}
