@extends('layouts.app')
@section('title','TEST user')
@section('content')

<h2 class="text text-center">Welcome To GTN</h2>

<table class="table">
  <thead>
      <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Status</th>

      </tr>
  </thead>
  <tbody>
      @foreach ($users as $item)
          <tr>
              <td>{{ $item->id }}</td>
              <td>{{ $item->name }}</td>
              <td>{{ $item->email }}</td>
              <td>{{ $item->status }}</td>
          </tr>
      @endforeach
  </tbody>

  <td>
    @if (Auth::check())
      <p>Your Status: {{ Auth::user()->status }}</p>
      @if (Auth::user()->status == 1)
        <a href="http://127.0.0.1:8000/blog">Blog</a>
        @else
      <P>สวัสดี status 0 </P>
      @endif
    @else
      
    @endif
  </td>
</table>





@endsection
