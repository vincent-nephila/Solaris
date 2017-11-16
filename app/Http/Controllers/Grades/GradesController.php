<?php

namespace App\Http\Controllers\Grades;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GradesController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    }

    function index(){
    	$user = \Auth::user();

    	$sy = \App\CtrSchoolYear::first();

    	$status = \App\Status::where('idno',$user->idno)->where('schoolyear',$sy->schoolyear)->first();
    	$grades = \App\Grade::where('idno',$user->idno)->where('schoolyear',$sy->schoolyear)->where('isdisplaycard',1)->orderBy('sortto')->get();

        $ctrAttendance = \App\CtrAttendance::where('schoolyear',$sy->schoolyear)->where('level',$status->level)->get();
        $attendances   = \App\Attendance::where('idno',$user->idno)->where('schoolyear',$sy->schoolyear)->groupBy('attendancetype')->orderBy('sortto','ASC')->get();

    	return view('grades.index',compact('grades','status','sy','ctrAttendance','attendances'));
    }

    static function getGradeQuarter($quarter){
        switch ($quarter){
            case 1; 
                $qrt = "first_grading";
            break;
            case 2;
                $qrt = "second_grading";
            break;                
           case 3;
                $qrt = "third_grading";
            break;
            case 4;
                $qrt = "fourth_grading";
           break; 
            case 5;
                $qrt = "final_grade";
           break;
            default:
                $qrt = "period";
                break;
        }
        return $qrt;
    }
}
