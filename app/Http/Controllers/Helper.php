<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Helper extends Controller
{
    

    static function enrollment_prevSchool(){
        $enrollYear = self::get_enrollmentSY();
        
        return $enrollYear-1;
    }
    
    static function get_enrollmentSY(){
        return \App\CtrYear::where('type','enrollment_year')->first()->year;
    }
    
    static function get_levelDept($level){
        $department = "";
        $level_dept = \App\CtrLevel::where('level',$level)->first();
        if($level_dept){
            $department = $level_dept->department;
        }
        
        return $department;
        
    }

    
}
