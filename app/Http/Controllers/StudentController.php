<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Http\Controllers\File;
use Storage;
use File as FileCustom;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::latest()->paginate(5);
        return view('student', compact('students'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create_student');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            "txtName" => "required",
            "txtAdd" => "required",
            "txtSchool" => "required",
            "txtFile" => "required|image|mimes:jpeg,png,jpg,svg,gif|max:2048",
        ]);

        $student = new Student();
        $student->name = $request->txtName;
        $student->address = $request->txtAdd;
        $student->school = $request->txtSchool;
        $file = $request->txtFile;

        $check = Storage::disk('public')->exists($file->getClientOriginalName());
        if ($check) {
            $file_name = time() . $file->getClientOriginalName();
            $file->storeAs('public/', $file_name);
            $url_file = "storage/" . $file_name;
        } else {
            $file_name = $file->getClientOriginalName();
            $file->storeAs('public/', $file_name);
            $url_file = "storage/" . $file_name;
        }
        $student->url_file = $url_file;
        $student->save();
        return redirect()->route('students.index')->with('success', 2);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = Student::find($id);
        if ($student) {
            return view('show_student', compact('student'));
        } else {
            return "No student found";
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student = Student::find($id);
        if ($student) {
            return view('edit_student', compact('student'));
        } else {
            return "No student found";
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate([
            'txtName' => 'required',
            'txtAdd' => 'required',
            'txtSchool' => 'required',
            'txtFile' => 'required|image|mimes:jpeg, jpg, png, gif, svg|max:2048',
        ]);

        $student =  Student::find($id);
        $file = $request->txtFile;

        $url_file_old = $student->url_file;
        $file_olds = explode("/", $url_file_old);
        $file_old = $file_olds[1];
        $student->name = $request->txtName;
        $student->address = $request->txtAdd;
        $student->school = $request->txtSchool;
        $file = $request->txtFile;
        $check = Storage::disk('public')->exists($file->getClientOriginalName());
        if (!$check) {
            $file_name =  $file->getClientOriginalName();
            $file->storeAs('/public', $file_name);
            $url_file = "storage/" . $file_name;
            echo "$check";
            Storage::disk('public')->delete($file_old);
        } else {
            if (md5(Storage::disk('public')->get($file_old)) == md5(FileCustom::get($file->getRealPath()))) {
                $file_name =  $file->getClientOriginalName();
                $file->storeAs('/public', $file_name);
                $url_file = "storage/" . $file_name;
            } else {
                $file_name =  time() . $file->getClientOriginalName();
                $file->storeAs('/public', time() . $file_name);
                $url_file = "storage/" . time() . $file_name;
                Storage::disk('public')->delete($file_old);
            }
        }
        $student->url_file = $url_file;
        $student->save();
        return redirect()->route('students.index')->with('success', 15);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = new Student();
        $user = $student::find($id);
        $url_file = $user->url_file;
        $file_names = explode("/", $url_file);
        $file_name = $file_names[1];
        Storage::disk('public')->delete($file_name);
        $user->delete();
        return redirect()->route('students.index')->with('success', 25);
    }
}
