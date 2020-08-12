@extends('master_student')
@section('students')
    <div class="container">
        <h1 class="d-flex justify-content-center">
            Create Student
        </h1>
    </div>
    @if (count($errors) > 0)
        <div class="container text-center">
            <strong>Whooops!!! </strong> There were some proplems withs yours input.
        </div>
    @endif
    <div class="container text-center">
        <form action="{{ route("students.store") }}" class="" method="POST" enctype="multipart/form-data">
            @csrf
            Name:<br>
            <input type="text" name="txtName"><br>
            <label style="color: red">{{ $errors->first('txtName') }}</label><br>

            Address:<br>
            <input type="text" name="txtAdd"><br>
            <label style="color: red">{{ $errors->first('txtAdd') }}</label><br>
            School:<br>
            <input type="text" name="txtSchool"><br>
            <label style="color: red">{{ $errors->first('txtSchool') }}</label> <br>
            <input type="file" name="txtFile"><br>
            <label style="color: red">{{ $errors->first('txtFile') }}</label><br>
            <a href="{{ route("students.index") }}" class="btn btn-success">Back</a>
            <button class="btn btn-primary" type="submit">Submit</button>
        </form>
    </div>
@stop
