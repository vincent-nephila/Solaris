<?php

namespace App\Http\Controllers\Assessement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Helper as MainHelper;
use App\Http\Controllers\StudentInfo as Info;
use App\Http\Controllers\Accounts\DetailsController as StudentAccounts;

class EnrollmentStatus extends Controller
{
    static function isEligible($idno,$lastSY){
        $promoted = self::isPromoted($idno, $lastSY);
        $noAccount = self::noRemainingBalance($idno);
        
        if(TRUE){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    static function isPromoted($idno,$schoolyear){
        $level = Info::get_level($idno, $schoolyear);
        
        $promotionFinal = self::isPromotionFinalized($level, $schoolyear);
        
        if($promotionFinal){
            $promotionstatus = self::studentpromition($idno, $schoolyear);
            switch ($promotionstatus){
                case "C":
                case "PO":
                    return FALSE;
                default :
                    return TRUE;
            }
        }else{
            return FALSE;
        }
    }
    
    static function studentpromition($idno,$schoolyear){
        $status = "";
        $promotion = \App\StudentPromotion::where('idno',$idno)->where('schoolyear',$schoolyear)->first();
        
        if($promotion){
            $status = $promotion->admission;
        }
        
        return $status;
    }
    
    static function isPromotionFinalized($level,$schoolyear){
        if($schoolyear < 2016){
            return FALSE;
        }
        
        $promotionFinal = \App\PromotionStatus::where('level',$level)->where('schoolyear',$schoolyear)->where('status',1)->first();
        
        if($promotionFinal){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    static function noRemainingBalance($idno){
        $ledgers = \App\Ledger::where('idno',$idno)->orderBy('categoryswitch')->orderBy('duedate')->get();
        
        $remainingBal = StudentAccounts::totalDue($ledgers);
        
        if($remainingBal > 0){
            return TRUE;
        }else{
            return FALSE;
        }   
    }
    
    
}
