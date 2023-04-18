<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use App\Models\Students;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CoursesController extends Controller
{
    
    public function index()
    {
        $courses = Courses::all()->join('courses_students','courses_students.students_id','=','courses_id.id');

        return Inertia::render('Courses/Index',['courses'=>$courses]);
    }


    public function create()
    {
        
        return Inertia::render('Courses/Create');

    }

    public function store(Request $request)
    {

        $request->validate([
            'name_course|max100',
            'schedule',
            'start_date',
            'end_date'
        ]);
        $courses = new Courses($request->input());
        $courses->save();
        return redirect('courses');
    }

    public function show(Courses $courses)
    {
        //
    }

    public function edit(Courses $course)
    {
        return Inertia::render('Courses/Edit',['course'=>$course]);
    }

    public function update(Request $request, Courses $course)
    {        
        $request->validate(['name_course|max100','schedule','start_date','end_date']);       
        $course->update($request->all());
        return redirect('courses');
    }

    public function destroy(Courses $course)
    {
        $course->delete();
        return redirect('courses');
    }
}
