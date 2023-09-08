@extends('layouts.master')

@section('pageTitle', $pageTitle)

@section('main')
  <div class="form-container">
    <h1 class="form-title">{{ $pageTitle }}</h1>
    <form class="form" method="POST" action="{{ route('tasks.update', ['id' => $task->id]) }}">
      @csrf
      @method('PUT')
      <div class="form-item">
        <label>Name:</label>
        <input
          class="form-input" name="name"
          type="text"
          value="{{ $task->name }}"
        >
        @error('name')
          <div class="alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-item">
        <label>Detail:</label>
        <textarea class="form-text-area" name="detail">{{ $task->detail }}</textarea>
      </div>

      <div class="form-item">
        <label>Due Date:</label>
        <input
          class="form-input" name="due_date"
          type="date"
          value="{{ $task->due_date }}"
        >
        @error('due_date')
          <div class="alert-danger">{{ $message }}</div>
        @enderror
      </div>

      <div class="form-item">
        <label>Progress:</label>
        <select class="form-input" name="status">
          <option @if($task->status == 'not_started') selected @endif value="not_started">
            Not Started
          </option>
          <option @if($task->status == 'in_progress') selected @endif value="in_progress">
            In Progress
          </option>
          <option @if($task->status == 'in_review') selected @endif value="in_review">
            Waiting/In Review
          </option>
          <option @if($task->status == 'completed') selected @endif value="completed">
            Completed
          </option>
        </select>
        @error('status')
          <div class="alert-danger">{{ $message }}</div>
        @enderror
      </div>
      <button type="submit" class="form-button" action="{{ route('tasks.edit', ['id' => $task->id, 'edittasksprogress' => 'task.progress']) }}">Submit</button>
    </form>
  </div>
@endsection