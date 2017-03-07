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
      </aside>
    </div>
  @else
    <div class="jumbotron">
      <h1>Hello Laravel</h1>
    <p class="lead">
      This is the home page of Learn Laravel
    </p>
    <p>
      Everything start from here!
    </p>
    <p>
      <!-- 注册 -->
      <a class="btn btn-lg btn-success" href="{{ route('signup') }}" role="button">Sign up now !</a> 
    </p>
  </div>
  @endif
@stop
