@extends('layouts.app')

@section('content')
<div class="container">
  @if (session('status'))
  <div class="alert alert-danger text-center">
    {{ session('status') }}
  </div>
  </div>
  @endif
  <h1>Hello {{$data['name']}}</h1>
  <h3>{{$data['email']}}</h3><br>

<h1>Update my info!</h1>
  <form class="form-inline" role="form" action="{{ url('/user/') }}" method="POST">  {{ csrf_field() }}
    <div class="form-group">
    <label class="sr-only" for="email">Name:</label>
    <input type="text" value="{{$data['name']}}" class="form-control" name="name" id="name" required>
  </div>
  <div class="form-group">
  <label class="sr-only" for="email">Email:</label>
  <input type="email" value="{{$data['email']}}" name="email" class="form-control" id="email" required>
</div>
  <div class="form-group">
    <label class="sr-only" for="pwd">Password:</label>
    <input type="password" class="form-control"  name="pwd" id="pwd" required>
  </div>
  <button type="submit" class="btn btn-default">Update</button>
  </form>

@endsection
