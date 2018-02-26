<?php

namespace App\Http\Controllers\Assessement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\StudentInfo as Info;
use App\Http\Controllers\Helper as MainHelper;
use App\Http\Controllers\Assessement\PlanController as Plan;
use App\Http\Controllers\Accounts\Helper as AcctHelper;


class Helper extends \App\Http\Controllers\Helper
{
    
    static function get_overrideStatus($idno){
        $enrollSY = self::get_enrollmentSY();
        return \App\EnrollmentStatusOverride::where('idno',$idno)->where('enrollmentyear',$enrollSY)->first();
    }
    
    static function level_up($idno,$level){
        $overriden = self::get_overrideStatus($idno);
        if($overriden){
            return $overriden->level;
        }
        switch($level){
           case "Kindergarten":
               return "Grade 1";
           case "Grade 1":
               return "Grade 2";
           case "Grade 2":
               return "Grade 3";
           case "Grade 3":
               return "Grade 4";
           case "Grade 4":
               return "Grade 5";
           case "Grade 5":
               return "Grade 6";
           case "Grade 6":
               return "Grade 7";
           case "Grade 7":
               return "Grade 8";
           case "Grade 8":
               return "Grade 9";
           case "Grade 9":
               return "Grade 10";
           case "Grade 10":
               return "Grade 11";
           case "Grade 11":
               return "Grade 12";
        }
    }
    static function get_viewStrand($newLevel,$idno,$schoolyear){
        $strand = self::get_hasStrand($newLevel,$idno,$schoolyear);
        
        
        if($strand !=""){
            
                if($newLevel == "Grade 10" || $newLevel == "Grade 12"){
                $mode = "specifiedStrand";
                return view('assess.subview.view_strand',compact('mode','strand'))->render();
            }
        }else{
            if($newLevel == "Grade 9" || $newLevel == "Grade 11"){
                $strands = \App\CtrLevelsStrand::where('level',$newLevel)->get();
                $mode = "selectStrand";
                return view('assess.subview.view_strand',compact('mode','strands'))->render();
            }
        }
    }
    static function get_hasStrand($newLevel,$idno,$schoolyear){
        $overriden = self::get_overrideStatus($idno);
        $strand = "";
        
        if($overriden){
            $strand = $overriden->strand;
        }else{
            if($newLevel == "Grade 9" || $newLevel == "Grade 11"){
                $strand = "";
            }

            
            if($newLevel == "Grade 10" || $newLevel == "Grade 12"){
                $strand = Info::get_strand($idno, $schoolyear);
            }
        }
        
        return $strand;
    }
    
    static function level_hasStrand($level){
        if(in_array($level,array('Grade 9','Grade 10','Grade 11','Grade 12'))){
            return True;
        }else{
            return FALSE;
        }
    }
    
    static function get_assessmentBreak($plan,$level,$strand = ""){
        
        
        if(Plan::isPlanValid($plan, $level, $strand)){
            $selectedPlan = Plan::get_plan($plan, $level, $strand);
            $books = \App\CtrBook::where('level',$level)->where('strand',$strand)->get();
            return self::get_accountView($selectedPlan,$books);
            
        }else{
            $message = "Sorry, there is currently no available plan for your selection.";
            return view('returnMessage',compact('message'))->render();
        }
    }
    
    static function getLedgerBreakdown($idno,$sy){
        $ledgers = AcctHelper::studentLedger($idno, $sy);
        return self::get_accountView($ledgers);
    }
    
    static function get_accountView($mainaccounts,$books = ""){
        return view('assess.subview.planbreakdown',compact('mainaccounts','books'))->render();
    }
}
