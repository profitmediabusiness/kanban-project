@extends('layouts.master')

@section('pageTitle', $pageTitle)

@section('main')
<div class="form-container">
    <h1 class="form-title">{{ $pageTitle }}</h1>
    <form class="form" method="POST" action="{{ route('task.store') }}">
      @csrf
      <div class="form-item">
        <label>Name:</label>
        <input class="form-input" type="text" value="{{ old('name') }}" name="name" >
        @error('name')
          <div class="alert-danger">{{ $message }}</div>
        @enderror
      </div>
  
      <div class="form-item">
        <label>Detail:</label>
        <textarea class="form-text-area" name="detail">{{ old('detail') }}</textarea>
      </div>
  
      <div class="form-item">
        <label>Due Date:</label>
        <input class="form-input" type="date" value="{{ old('due_date') }}" name="due_date" >
        @error('due_date')
          <div class="alert-danger">{{ $message }}</div>
        @enderror
      </div>
  
      <div class="form-item">
        <label>Progress:</label>
        <select class="form-input" name="status">
          <option value="not_started" {{ old('status') == 'not_started' ? 'selected' : "" }}>Not Started</option>
          <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : "" }}>In Progress</option>
          <option value="in_review" {{ old('status') == 'in_review' ? 'selected' : "" }}>Waiting/In Review</option>
          <option value="completed" {{ old('status') == 'completed' ? 'selected' : "" }}>Completed</option>
        </select>
        @error('status')
          <div class="alert-danger">{{ $message }}</div>
        @enderror
      </div>
      <input type="submit" class="form-button" value="Submit"/>
    </form>
  </div>
  @endsection