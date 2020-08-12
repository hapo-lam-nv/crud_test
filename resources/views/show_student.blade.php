@extends('master_student')
@section('students')
    <div class="container">
        <h1 class="d-flex justify-content-center">
            Information Student
        </h1>
    </div>
    <div class="container">
        <table class="table table-bordered">
            <tr>
                <th>Information</th>
            </tr>
            <tr>
                <td>{{ $student["name"] . "-" . $student['address'] . "-" . $student['school']}}</td>
            </tr>
        </table>
        <img src="{{ asset($student['url_file']) }}" alt="image_error">
    </div>
@stop
