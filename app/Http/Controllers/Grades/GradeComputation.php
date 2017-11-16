<?php

namespace App\Http\Controllers\Grades;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Grades\GradesController;

class GradeComputation extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    }

    static function computeQuarterAverage($sy,$level,$subjecttype,$sem,$quarter,$grades){
        
        $gradeCondition = \App\GradesSetting::where('schoolyear',$sy)->where('level',$level)->whereIn('subjecttype',$subjecttype)->first();
        $field = GradesController::getGradeQuarter($quarter);
        if($gradeCondition){
            if($gradeCondition->calculation == "A"){
                return self::averageGrade($subjecttype,$sem,$grades,$field,$gradeCondition);
            }elseif($gradeCondition->calculation == "W"){
                return self::weightedGrade($subjecttype,$sem,$grades,$field,$gradeCondition);
            }elseif($gradeCondition->calculation == "P"){
                return self::pointedGrade($subjecttype,$quarter,$sem,$grades,$field,$gradeCondition);
            }else{
                return "";
            }   
        }else{
            return "";
        }
    }

    static function averageGrade($subjecttype,$sem,$grades,$field,$gradeCondition){
        $total = 0;
        $average = 0;
        foreach($grades as $grade){
            if(in_array($grade->subjecttype,$subjecttype) && $grade->semester == $sem && $grade->$field != 0){
                $total = $total + 1;
                $average = $average + $grade->$field;
            }
        }
        if($total == 0 || $average == 0){
            return "";
        }
        if(($average/$total) < 100){
            $average = number_format(round($average/$total,$gradeCondition->decimal),$gradeCondition->decimal);
        }else{
            $average = round($average/$total,0);
        }
        
        return $average;
    }
    
    static function weightedGrade($subjecttype,$sem,$grades,$field,$gradeCondition){
        $average = 0;
        
        foreach($grades as $grade){
            if(in_array($grade->subjecttype,$subjecttype) && $grade->semester == $sem && $grade->$field != 0){
                $average = $average + round($grade->$field * ($grade->weighted/100),$gradeCondition->decimal);
            }
        }
        
        if($average == 0){
            return "";
        }
        
        if($average < 100){
            $average = number_format($average,$gradeCondition->decimal);
        }else{
            $average = round($average,0);
        }
        
        return $average;
    }
    
    static function pointedGrade($subjecttype,$quarter,$sem,$grades,$field,$gradeCondition){
        $average = 0;
        
        if($quarter != 5){
            foreach($grades as $grade){
                if(in_array($grade->subjecttype,$subjecttype) && $grade->$field != 0){
                    $average = $average + $grade->$field;
                }
            }
            if($average == 0){
                return "";
            }
            
            return $average;
        }else{
            $average = self::pointedTotalAve($subjecttype, $sem, $grades, $field, $gradeCondition);
            
            if($average == 0){
                return "";
            }

            if($average < 100){
                $average = number_format(round($average,$gradeCondition->decimal),$gradeCondition->decimal);
            }else{
                $average = round($average,0);
            }

            return $average;
        }
        

    }
    
    static function pointedTotalAve($subjecttype,$sem,$grades,$field,$gradeCondition){
        $grade = 0;
        if($sem == 0){
            $first =  self::pointedGrade($subjecttype,1,$sem,$grades,'first_grading',$gradeCondition);
            $second = self::pointedGrade($subjecttype,2,$sem,$grades,'second_grading',$gradeCondition);
            $third =  self::pointedGrade($subjecttype,3,$sem,$grades,'third_grading',$gradeCondition);
            $fourth = self::pointedGrade($subjecttype,4,$sem,$grades,'fourth_grading',$gradeCondition);
            
            if($fourth != ""){   
                $grade = ($first+$second+$third+$fourth)/4;
            }
        }elseif($sem ==1){
            $first =  self::pointedGrade($subjecttype,1,$sem,$grades,'first_grading',$gradeCondition);
            $second = self::pointedGrade($subjecttype,2,$sem,$grades,'second_grading',$gradeCondition);

            if($second != ""){
                $grade = ($first+$second)/2;
            }
        }elseif($sem ==2){
            $third =  self::pointedGrade($subjecttype,3,$sem,$grades,'third_grading',$gradeCondition);
            $fourth = self::pointedGrade($subjecttype,4,$sem,$grades,'fourth_grading',$gradeCondition);
            
            if($fourth != ""){
                $grade = ($third+$fourth)/2;
            }
        }
        
        return $grade;
    }
}
