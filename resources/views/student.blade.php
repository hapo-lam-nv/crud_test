@extends('master_student')
@section('students')
<div class="container mt-5">
    <h1 class="row mx-auto d-flex justify-content-center">CRUD TUTORIAL</h1>
</div>
@if (Session::has('success'))
{{ trans_choice('message.success', session('success')) }}
@endif
<div class="float-right">
    <a href="{{ route('students.create') }}" class="btn btn-success">Create New Student</a>
</div>
<table class="table table-bordered">
    <tr>
        <th>No.</th>
        <th>Name</th>
        <th>Address</th>
        <th>School</th>
        <th>Image</th>
        <th>Action</th>
    </tr>
    @foreach ($students as $student)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $student['name'] }}</td>
            <td>{{ $student['address'] }}</td>
            <td>{{ $student['school'] }}</td>
            <td><img style="width: 100px; height: 50px" src="{{ asset($student['url_file']) }}" alt="image_error"></td>
            
            <td>
                <form action="{{ route('students.destroy', $student['id']) }}" method="POST">
                    <a href="{{ route('students.show', $student['id']) }}" class="btn btn-info">Show</a>
                    <a href="{{ route('students.edit', $student['id']) }}" class="btn btn-primary">Edit</a>
                    @csrf
                    @method("DELETE")
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure delete item')">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
{{ $students->links() }}
@stop
