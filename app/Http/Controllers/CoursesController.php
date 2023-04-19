<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use App\Models\Students;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class CoursesController extends Controller
{
    
    public function index()
    {
        $courses = Courses::all();

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
        return $course;
        $request->validate(['name_course|max100','schedule','start_date','end_date']);       
        $course->update($request->all());
        return redirect('courses');
    }

    public function destroy(Courses $course)
    {
        $course->delete();
        return redirect('courses');
    }

    public function searchData(Request $request){

        $start = explode("-",$request->startDate);
        $end = explode("-",$request->endDate);

        $date1 = Carbon::createFromDate($start[0],$start[1],$start[2]);
        $date2 = Carbon::createFromDate($end[0],$end[1],$end[2]);

        $courses = Courses::all();
        $students = Students::where('created_at','>=',$date1)->where('created_at','<=',$date2)->get();

        $filterCourses = [];

        foreach ($courses as $key => $course) {

            $filterStudents = [];

            foreach ($students as $key => $student) {
                
                $studentCourses= json_decode($student['courses'],true);
                $id = $course['id'];

                $search = in_array($id,$studentCourses);
                
                if ($search) {
                    $filterStudents[] = $student;
                }

            }

            if (count($filterStudents)) {
                $course['students'] = $filterStudents;
                $course['studentsTotal'] = count($filterStudents);
                $filterCourses[] = $course;
            }
        
        }

        foreach ($filterCourses as $key => $row) {
            $distance[$key] = $row['studentsTotal'];
        }

        array_multisort($distance, SORT_DESC, $filterCourses);

        $courserMaxStudents = [];
        $cantOption = $request->selectOption -1 ;
        for ($i=0; $i <= $cantOption ; $i++) { 
            array_push($courserMaxStudents,$filterCourses[$i]);
        }
     
        return $courserMaxStudents; 
                          
    }
}
