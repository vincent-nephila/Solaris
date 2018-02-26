<?php 
use App\Http\Controllers\StudentInfo as Info;
use App\Http\Controllers\Assessement\Helper as AssHelper;
use App\Http\Controllers\Helper as MainHelper;
?>
@extends('layouts.app')
@section('header')
	<section class="content-header">
		<h1>Assessment</h1>
		<ol class="breadcrumb">
		  <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
		  <li class="active">Assessment</li>
		</ol>
	</section>
@stop
@section('content')
<section class="content">
    <form method='POST' action='{{route("processAssessment")}}'>
        {{ csrf_field() }}
    <div class="row">
        <div class="col-md-6">
            <table class="table table-striped">
                <tr>
                    <td><b>Name:</b></td>
                    <td>{{Info::get_nameFormal($idno)}}</td>
                </tr>
                <tr>
                    <td><b>Last Level:</b></td>
                    <td>{{$laststatus->level}}</td>
                </tr>
                @if($laststatus->strand != "")
                
                <tr>
                    <td><b>Strand:</b></td>
                    <td>{{$laststatus->strand}}</td>
                </tr>
                @endif
                <tr>
                    <td><b>Last Section:</b></td>
                    <td>{{$laststatus->section}}</td>
                </tr>
            </table>
            
            
            <!--This is for assessment .....-->
            <?php 
            $newLevel = AssHelper::level_up($idno,$laststatus->level);
            $plans = App\CtrRefSchedule::groupBy('plan')->orderBy('id','DESC')->get();
            ?>
            <hr>
            <h4>Assessment for {{MainHelper::get_enrollmentSY()}} - {{MainHelper::get_enrollmentSY() +1}}:</h4>
            <div class="col-md-12">
                <label>Level</label>
                <div class="form-control">{{$newLevel}}</div>
            </div>
            
            <div class="col-md-12">
                {!!AssHelper::get_viewStrand($newLevel,$idno,$laststatus->schoolyear)!!}
            </div>

            
            <div class="col-md-12">
                <label>Plan</label>
                <select class="form-control" name="plan" id='plan'>
                    <option value='' hidden='hidden'>--Select A Plan--</option>
                    @foreach($plans as $plan)
                    <option value='{{$plan->plan}}'>{{$plan->plan}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class='col-md-6' id='showAssessment'></div>
    </div>    
    </form>
    {{AssHelper::get_hasStrand($newLevel,$idno,$laststatus->strand)}}
</section>
@stop

@section('java')
$('#strand,#plan').change(function(){

$.ajax({
    @if(AssHelper::get_hasStrand($newLevel,$idno,$laststatus->schoolyear) == "" && AssHelper::level_hasStrand($newLevel))
    'url':"/planassessement/"+$('#plan').val()+"/"+$('#strand').val(),
    @else
    'url':"/planassessement/"+$('#plan').val(),
    @endif
    'success':function(data){
        $('#showAssessment').html(data);
    }
    
})
})

function select_all(){
    $('.books').prop('checked', 'checked');
    $('#check_uncheck').html("<p style=\"cursor:pointer\" onclick=\"unselect_all()\">Uncheck All</p>")
}

function unselect_all(){
    //alert("hello")
    $('.books').prop('checked',false);
    $('#check_uncheck').html("<p style=\"cursor:pointer\" onclick=\"select_all()\">Select All</p>");
}


@stop
