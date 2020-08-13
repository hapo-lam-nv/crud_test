<?php

namespace App\Http\Controllers;

use App\Student;
use App\Http\Controllers\File;
use Storage;
use File as FileCustom;
use App\Http\Requests\MessageRequest;
use App\Http\Requests\UpdateRequest;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::latest()->paginate(config('variable.pagination'));
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
    public function store(MessageRequest $request)
    {
        $student = new Student();
        $student->name = $request->txtName;
        $student->address = $request->txtAdd;
        $student->school = $request->txtSchool;
        $file = $request->txtFile;
        $fileName = time() . $file->getClientOriginalName();
        $file->storeAs('public/', $fileName);
        $urlFile = config('variable.url_upload') . $fileName;
        $student->url_file = $urlFile;
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
    public function update(UpdateRequest $request, $id)
    {
        $student = Student::find($id);
        $urlFileOld = $student->url_file;
        $fileOlds = explode("/", $urlFileOld);
        $fileOld = $fileOlds[1];
        $student->name = $request->txtName;
        $student->address = $request->txtAdd;
        $student->school = $request->txtSchool;
        $file = $request->txtFile;
        if ($file) {
            $check = Storage::disk('public')->exists($file->getClientOriginalName());

            if (!$check) {
                $fileName =  $file->getClientOriginalName();
                $file->storeAs('/public', $fileName);
                $urlFile = config('variable.url_upload') . $fileName;
                Storage::disk('public')->delete($fileOld);
            } else {
                $fileName =  time() . $file->getClientOriginalName();
                $file->storeAs('/public', $fileName);
                $urlFile = config('variable.url_upload') . $fileName;
                Storage::disk('public')->delete($fileOld);
            }

            $student->url_file = $urlFile;
        }
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
        $user = Student::find($id);
        $urlFile = $user->url_file;
        $fileNames = explode("/", $urlFile);
        $fileName = $fileNames[1];
        Storage::disk('public')->delete($fileName);
        $user->delete();
        return redirect()->route('students.index')->with('success', 25);
    }
}
