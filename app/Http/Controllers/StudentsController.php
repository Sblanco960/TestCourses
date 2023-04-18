<?php

namespace App\Http\Controllers;

use App\Models\Students;
use App\Models\Courses;
use Illuminate\Http\Request;
use Inertia\Inertia;
use DB;

class StudentsController extends Controller
{
    
    public function index()
    {
        $students = Students::select('students.id', 'students.name','students.last_name','students.age','students.email','students.course_id','courses.name_course as courses')
        ->join('courses','courses.id','=','students.course_id')
        ->paginate(10);

        $courses = Courses::all();
        return Inertia::render('Students/Index',['students'=>$students,'courses'=>$courses]);
    }

    

    public function store(Request $request)
    {
        $request->validate([
            'name|max100',
            'last_name|max100',
            'age',
            'email',
            'courses' => 'required'
        ]);

        $students = new Students($request->input());
        $students->save();
        return redirect('students');
    }

    public function show(Students $students)
    {
        //
    }

    public function edit(Students $students)
    {
        //
    }

    public function update(Request $request, Students $students)
    {

        $request->validate([
            'name|max100',
            'last_name|max100',
            'age',
            'email',
            'departmen_id' => 'required|numeric'
        ]);

        $students->update($request->input());        
        return redirect('students');

    }
    
    public function destroy(Students $student)
    {
        $student->delete();
        return redirect('students');
    }

    public function StudentsByCourses(){

        $data = Students::select(DB::raw('count(students.id) as count, courses.name_course'))
        ->join('courses','courses.id','=','students.course_id')
        ->groupBy('courses.name_course')->get();
        
        return Inertia::render('Students/Graphic',['date'=>$data]);

    }




}
