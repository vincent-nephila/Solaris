<?php 
use App\Http\Controllers\StudentInfo as Info;
use App\Http\Controllers\Assessement\Helper as AssHelper;
use App\Http\Controllers\Helper as MainHelper;

Info::get_section($idno, $currEnrollment);
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
    <div class="row">
        <div class="col-md-6">
            <table class="table table-striped">
                <tr>
                    <td><b>Name:</b></td>
                    <td>{{Info::get_nameFormal($idno)}}</td>
                </tr>
                <tr>
                    <td><b>Level:</b></td>
                    <td>{{Info::get_level($idno, $currEnrollment,TRUE)}}</td>
                </tr>
                @if(Info::get_strand($idno, $currEnrollment,true) != "")
                
                <tr>
                    <td><b>Strand:</b></td>
                    <td>{{Info::get_strand($idno, $currEnrollment,true)}}</td>
                </tr>
                @endif
            </table>

        </div>
        
        <div class='col-md-6' id='showAssessment'>
            {!!AssHelper::getLedgerBreakdown($idno,$currEnrollment)!!}
        </div>
    </div>    

</section>
@stop


