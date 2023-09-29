@extends('layouts.master')
@section('pageTitle', $pageTitle)

@section('main')
@php
    use App\Models\Task;
@endphp
<div class="task-list-container">
  <h1 class="task-list-heading">Task List</h1>

  <div class="task-list-task-buttons">
    <a href="{{ route('tasks.create') }}">
      <button  class="task-list-button">
        <span class="material-icons">add</span>Add task
      </button>
    </a>
  </div>
  
  <div class="task-list-table-head">
    <div class="task-list-header-task-name">Task Name</div>
    <div class="task-list-header-detail">Detail</div>
    <div class="task-list-header-due-date">Due Date</div>
    <div class="task-list-header-progress">Progress</div>
    <div class="task-list-header-owner-name">Owner</div>
  </div>

  @foreach ($tasks as $index => $task)
    <div class="table-body">
      <div class="table-body-task-name">
        @if ($task->status == 'completed')
        <span class="material-icons task-progress-card-top-checked"> check_circle </span>
        @else
        <form id="set-complete-{{ $task->id }}" action="{{ route('tasks.move', ['id' => $task->id, 'status' => Task::STATUS_COMPLETED, 'movetasklist' => 'task.list']) }}" 
          method="POST">
          @method('patch')
          @csrf
        <span onclick="document.getElementById('set-complete-{{ $task->id }}').submit()" class="material-icons task-progress-card-top-check"> check_circle </span>
      </form>
        @endif
        {{ $task->name }}
      </div>
      <div class="table-body-detail"> {{ $task->detail }} </div>
      <div class="table-body-due-date"> {{ $task->due_date }} </div>
      <div class="table-body-progress">
        @switch($task->status)
          @case('in_progress')
            In Progress
            @break
          @case('in_review')
            Waiting/In Review
            @break
          @case('completed')
            Completed
            @break
          @default
            Not Started
        @endswitch
      </div>
      <div class="table-body-owner-name">{{ $task->user->name }}</div>
      <div>
        {{--  @can('update', $task)  --}}
        <a href="{{ route('tasks.edit', ['id' => $task->id]) }}">Edit</a>
        {{--  @endcan  --}}
        
        {{--  @can('delete', $task)  --}}
        <a href="{{ route('tasks.delete', ['id' => $task->id]) }}">Delete</a>
        {{--  @endcan  --}}
      </div>
      </div>
  @endforeach
</div>
@endsection