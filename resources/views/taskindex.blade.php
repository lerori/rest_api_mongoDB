<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Index Page</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
  </head>
  <body>
    <div class="container">
    <br />
    @if (\Session::has('success'))
      <div class="alert alert-success">
        <p>{{ \Session::get('success') }}</p>
      </div><br />
     @endif
      <tr>
        <td><a href="{{action('TaskController@create')}}" class="btn btn-warning">Create</a></td>
        <td>
      </tr>
    <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Description</th>
        <th>Due date</th>
        <th>Completed</th>
        <th colspan="2">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($tasks as $task)
      <tr>
        <td>{{$task->id}}</td>
        <td>{{$task->title}}</td>
        <td>{{$task->description}}</td>
        <td>{{$task->due_date}}</td>
        <td>{{$task->completed}}</td>
        <td><a href="{{action('TaskController@edit', $task->_id)}}" class="btn btn-warning">Edit</a></td>
        <td>
          <form action="{{action('TaskController@destroy', $task->_id)}}" method="post">
            @csrf
            <input name="_method" type="hidden" value="DELETE">
            <button class="btn btn-danger" type="submit">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  </div>
  </body>
</html>