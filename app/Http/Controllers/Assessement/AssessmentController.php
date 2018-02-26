<?php

namespace App\Http\Controllers\Assessement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\StudentInfo as Info;
use App\Http\Controllers\Helper as MainHelper;
use App\Http\Controllers\Assessement\EnrollmentStatus;
use App\Http\Controllers\Assessement\Helper as AssHelper;
use App\Http\Controllers\Accounts\Helper as AcctHelper;
class AssessmentController extends Controller
{
    function view(){
        $user = \Auth::user();
        $lastEnrollmentYear = MainHelper::enrollment_prevSchool();
        $lastYearAStudent = Info::get_StudentSyInfo($user->idno, $lastEnrollmentYear);
        $currEnrollment = MainHelper::get_enrollmentSY();
        
        
        if(in_array(Info::get_status($user->idno, $currEnrollment),array(1,2,3))){
            $idno = $user->idno;
            return view('assess.assessed',compact('currEnrollment','idno'));
        }
        
        if($lastYearAStudent){
            return $this->lastYearAStudentView($user->idno, $lastYearAStudent);
        }else{
            $returning = \App\StatusHistory::where('idno',$user->idno)->where('schoolyear','>',$lastEnrollmentYear)->whereIn('status',array(2,3))->orderBy('schoolyear','DESC')->first();
            if($returning){
                $this->returneeView($user->idno,$returning->schoolyear);
            }else{
                return view('assess.sorry');
            }
        }
    }
    
    function returneeView($idno,$lastSy){
        
    }
    
    function lastYearAStudentView($idno,$laststatus){
        $isEligble = EnrollmentStatus::isEligible($idno, $laststatus->schoolyear);
        if($isEligble){
            return view('assess.assess',compact('laststatus','idno'));
        }else{
            return view('assess.sorry');
        }
    }
    
    function printAssessement(){
        $schoolyear = MainHelper::get_enrollmentSY();
        $idno = \Auth::user()->idno;
        
        $mainaccounts = AcctHelper::studentLedger($idno, $schoolyear);
        
       $pdf = \App::make('dompdf.wrapper');
       $pdf->setPaper('letter', 'portrait');
        $pdf->loadView("assess.printassessment",compact('idno','schoolyear','mainaccounts'));
       return $pdf->stream();
    }
    
    
    
}
