<?php

namespace App\Http\Controllers\Assessement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{
    static function get_plan($plan,$level,$strand){
        if($strand == ""){
            $strand = NULL;
        }
        return \App\CtrPaymentSchedule::where('level',$level)->where('strand',$strand)->where('plan',$plan)->get();
    }
    
    static function isPlanValid($plan,$level,$strand){
        $planSched = self::get_plan($plan, $level, $strand);
        
        if(count($planSched)> 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}
