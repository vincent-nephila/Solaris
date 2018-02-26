<?php

namespace App\Http\Controllers\Assessement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Assessement\Helper as AssHelper;
use App\Http\Controllers\Helper as MainHelper;
use App\Http\Controllers\StudentInfo as Info;

class AjaxController extends Controller
{
    function getPlanView($plan,$strand = ""){
        $user = \Auth::user();
        $lastEnrollmentYear = MainHelper::enrollment_prevSchool();
        $lastYearAStudent = Info::get_StudentSyInfo($user->idno, $lastEnrollmentYear);
        
        if($lastYearAStudent){
            $level = AssHelper::level_up($user->idno,$lastYearAStudent->level);
            if($strand ==""){
                $strand = AssHelper::get_hasStrand($level,$user->idno,$lastEnrollmentYear);
            }
            
        }else{
            $returning = \App\StatusHistory::where('idno',$user->idno)->where('schoolyear','>',$lastEnrollmentYear)->whereIn('status',array(2,3))->orderBy('schoolyear','DESC')->first();
            if($returning){
                $level = AssHelper::level_up($user->idno,$returning->level);
                if($strand ==""){
                    $strand = AssHelper::get_hasStrand($level,$user->idno,$returning->schoolyear);
                }
                
            }else{
                $level = "";
            }
        }
        return AssHelper::get_assessmentBreak($plan,$level,$strand);
       
    }
}
