@extends('ui.layouts.app', ['title' => 'Dashboard'])

@section('content')

    @if(Auth::user()->role == "Super User")

         <h3>Super user dashboard</h3>
    @endif


    @if(Auth::user()->role == "")

        <h3>User dashboard</h3>

    @endif


@endsection
