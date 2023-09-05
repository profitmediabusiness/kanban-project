<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
class TaskController extends Controller
{
    private $tasks;

    public function __construct()
    {
        $this->tasks = [
            (object) [
                'id' => 1,
                'name' => 'Develop Final Project',
                'detail' => 'Kanban project using PHP and Laravel',
                'due_date' => '2023-04-30',
                'status' => 'not_started',
            ],
            (object) [
                'id' => 2,
                'name' => 'Lunch with Guru Domba',
                'detail' => 'Have Nasi Padang with Guru Domba',
                'due_date' => '2023-04-10',
                'status' => 'not_started',
            ],
            (object) [
                'id' => 3,
                'name' => 'Learn Blade Templating',
                'detail' => 'Complete Blade Templating material on Progate',
                'due_date' => '2023-04-05',
                'status' => 'in_progress',
            ],
            (object) [
                'id' => 4,
                'name' => 'Decide Plans for Lebaran holidays',
                'detail' => 'Trip with family?',
                'due_date' => '2023-04-21',
                'status' => 'in_progress',
            ],
            (object) [
                'id' => 5,
                'name' => 'Develop a Laravel Project',
                'detail' => 'Develop a Kanban app and ask Guru Domba\'s review',
                'due_date' => '2023-04-30',
                'status' => 'in_review',
            ],
            (object) [
                'id' => 6,
                'name' => 'Learn PHP Basics',
                'detail' => 'Complete PHP materials on Frontend Course',
                'due_date' => '2023-04-30',
                'status' => 'completed',
            ],
        ];
    }

    public function index()
    {
        
        $pageTitle = 'Task List';
        $tasks = Task::all();
        return view('tasks.index', [
            'pageTitle' => $pageTitle,
            'tasks' => $tasks
        ]);
    }
    public function edit($id)
    {
        
        $pageTitle = 'Edit Task';
        $task = Task::find($id);

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

        return view('tasks.delete', ['pageTitle' => $pageTitle, 'task' => $task]);


    }

    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();
        
        return redirect()->route('tasks.index');
    }

    public function progres() 
    {
        $title = 'Task Progres';
        $semuatask = Task::all();
        $tasktertentu = $semuatask->groupBy('status');
        // echo $tasktertentu;
        $tasks = [
            Task::STATUS_NOT_STARTED => $tasktertentu -> get(Task::STATUS_NOT_STARTED, []),
            Task::STATUS_IN_PROGRESS=> $tasktertentu -> get(Task::STATUS_IN_PROGRESS, []),
            Task::STATUS_COMPLETED=> $tasktertentu -> get(Task::STATUS_COMPLETED, []),
            Task::STATUS_IN_REVIEW=> $tasktertentu -> get(Task::STATUS_IN_REVIEW, []),
        ];
        // dump($tasks);
        return view('tasks.progress', ['pageTitle' => $title, 'tasks' => $tasks]);
    }


}
