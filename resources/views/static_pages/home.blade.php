@extends('layouts.default')

@section('content')
  @if (Auth::check())
    <div class="row">
      <div class="col-md-8">
        <section class="status_form">
          @include('shared.status_form')
        </section>
        <h3>Statuses List</h3>
        @include('shared/feed')
      </div>
      <aside class="col-md-4">
        <section class="user_info">
          @include('shared.user_info', ['user' => Auth::user()])
        </section>
        <section class="stats">
          @include('shared.stats', ['user' => Auth::user()])
        </section>
      </aside>
    </div>
  @else
    <div class="jumbotron">
      <h1>Hello Laravel</h1>
      <p class="lead">
        What you are seeing now is an  <a href="https://laravel-china.org/laravel-tutorial/5.1">Laravel tutorial</a> Home Page。
      </p>
      <p>
        Everything will start from here!
      </p>
      <p>
        <a class="btn btn-lg btn-success" href="{{ route('signup') }}" role="button">Register now</a>
      </p>
    </div>    
  @endif
@stop
