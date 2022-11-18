@extends('ui.layouts.app', ['title' => 'Dashboard'])

@section('content')
    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('img/miri/favicon.ico') }}" type="image/x-icon">
    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>

<body>

<div class="card">
    <div class="card-header">
        Task Management App
    </div>
    <div class="card-body">
        <h5 class="card-title">This is how you manage your  Tasks</h5>
        <p class="card-text">Time is always limited.</p>
        <p class="card-text">Anyone with access to this app can schedule any desired task .</p>
        <p class="card-text">The app is not limited to Any  ideas and improvements.</p>
        <p class="card-text">Basically the admin has the power to review tasks created.</p>
        <h5 class="card-title">Steps to schedule your task</h5>
        <p class="card-text">After a succesfull login proceed to my tasks menu.</p>
        <p class="card-text">Add any desired task .</p>
        <p class="card-text">Set the dateline for the  desired task.</p>
        <p class="card-text">After a task is complete the admin approves it</p>
       
    </div>
</div>






















</body>

</html>
@endsection
