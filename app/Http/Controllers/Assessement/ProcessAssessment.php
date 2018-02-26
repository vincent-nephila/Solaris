<?php

namespace App\Http\Controllers\Assessement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Assessement\Helper as AssHelper;
use App\Http\Controllers\Helper as MainHelper;
use App\Http\Controllers\StudentInfo as Info;
use App\Http\Controllers\Assessement\PlanController as Plan;
use App\Http\Controllers\Assessement\ProcessStatus as Stat;
use App\Http\Controllers\Assessement\ProcessLedger as Ledr;
use App\Http\Controllers\Assessement\ProcessSubjects as Subjects;
use App\Http\Controllers\Assessement\ProcessReservation as Reserve;
use App\Http\Controllers\Assessement\ProcessDeposit as Deposit;
use App\Http\Controllers\Assessement\ProcessBooks as Books;


class ProcessAssessment extends Controller
{
    function save(Request $request){
        $requestStrand = $request->input('strand');
        $plan = $request->input('plan');
        $user = \Auth::user();
        $books = $request->input('books');
        
        $info = $this->validateInfo($user->idno, $requestStrand);
        $level = $info['level'];
        $strand = $info['strand'];
        
        if(Plan::isPlanValid($plan, $level, $strand)){
            Stat::process_Status($user->idno,$level,$strand,$plan);
            Ledr::processLedger($user->idno, $level, $strand, $plan);
            Books::processBooks($books, $user->idno);
            Reserve::activateReservation($user->idno);
            Deposit::activateDeposit($user->idno);
            Subjects::processSubjects($user->idno, $level, $strand);   
        }
        
        return redirect()->route('selfassess');
    }
    
    function validateInfo($idno,$strand){
        $lastEnrollmentYear = MainHelper::enrollment_prevSchool();
        $lastYearAStudent = Info::get_StudentSyInfo($idno, $lastEnrollmentYear);
        
        if($lastYearAStudent){
            $level = AssHelper::level_up($idno,$lastYearAStudent->level);
            if($strand ==""){
                $strand = AssHelper::get_hasStrand($level,$idno,$lastEnrollmentYear);
            }
            
        }else{
            $returning = \App\StatusHistory::where('idno',$idno)->where('schoolyear','>',$lastEnrollmentYear)->whereIn('status',array(2,3))->orderBy('schoolyear','DESC')->first();
            if($returning){
                $level = AssHelper::level_up($idno,$returning->level);
                if($strand ==""){
                    $strand = AssHelper::get_hasStrand($level,$idno,$returning->schoolyear);
                }
                
            }else{
                $level = "";
            }
        }
        
        return ["level"=>$level,"strand"=>$strand];
    }
    
    function reassess(Request $request){
            $schoolyear = MainHelper::get_enrollmentSY();
            $user = \Auth::user();
            
            Stat::deleteStatus($user->idno, $schoolyear);
            Ledr::deleteLedger($user->idno, $schoolyear);
            Reserve::deactivateReservation($user->idno);
            Subjects::deleteSubjects($user->idno, $schoolyear);
            
            return redirect()->route('selfassess');
        }
}
