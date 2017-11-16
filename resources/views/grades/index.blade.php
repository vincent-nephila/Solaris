@extends('layouts.app')
<?php 
use App\Http\Controllers\Grades\GradeComputation;
$subjecttypes = $grades->unique('subjecttype')->pluck('subjecttype')->toArray();
?>

@section('header')
	<section class="content-header">
		<h1>Grades</h1>
		<small>{{$status->level}} - {{$status->section}}</small>
		<ol class="breadcrumb">
		  <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
		  <li class="active">Grades</li>
		</ol>
	</section>
@stop

@if($status->department != 'Senior High School')
<?php
//Ctr Attendance Variables
$jun = $ctrAttendance->sum('Jun');
$jul = $ctrAttendance->sum('Jul');
$aug = $ctrAttendance->sum('Aug');
$sept = $ctrAttendance->sum('Sept');
$oct = $ctrAttendance->sum('Oct');
$nov = $ctrAttendance->sum('Nov');
$dec = $ctrAttendance->sum('Dece');
$jan = $ctrAttendance->sum('Jan');
$feb = $ctrAttendance->sum('Feb');
$mar = $ctrAttendance->sum('Mar');
?>
@section('content')
	<section class="content">
		<div class="row">
			<!--Column 1-->
			<div class="col-md-6">
				<!--Academic Grades Box-->
				@if(in_array(0,$subjecttypes))
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Subjects</h3>
					</div>
					<div class='box-body table-responsive no-padding'>
						<table class="table table-striped" style="font-size:9.5pt;text-align: center">
							<thead>
							<tr>
								<th style="text-align: left">Subject</th>
								<th>1st</th>
								<th>2nd</th>
								<th>3rd</th>
								<th>4th</th>
								<th>Final Grade</th>
								</tr>
							</thead>
							@foreach($grades as $subject)
							@if($subject->subjecttype == 0)
							<?php $gradeSetting = App\GradesSetting::where('subjecttype',$subject->subjecttype)->where('schoolyear',$sy->schoolyear)->first();?>
							<tr>
								<td style="text-align: left">{{$subject->subjectname}}</td>
								<td>{{$subject->first_grading != 0 ?round($subject->first_grading,$gradeSetting->decimal):""}}</td>
								<td>{{$subject->second_grading != 0 ?round($subject->second_grading,$gradeSetting->decimal):""}}</td>
								<td>{{$subject->third_grading != 0 ?round($subject->third_grading,$gradeSetting->decimal):""}}</td>
								<td>{{$subject->fourth_grading != 0 ?round($subject->fourth_grading,$gradeSetting->decimal):""}}</td>
								<td>{{$subject->final_grade != 0 ?round($subject->final_grade,$gradeSetting->decimal):""}}</td>
							</tr>
							@endif
							@endforeach
							<tr>
								<td style="text-align: left">ACADEMIC AVERAGE</td>
								<td>{{GradeComputation::computeQuarterAverage($status->schoolyear,$status->level,array(0),0,1,$grades)}}</td>
								<td>{{GradeComputation::computeQuarterAverage($status->schoolyear,$status->level,array(0),0,2,$grades)}}</td>
								<td>{{GradeComputation::computeQuarterAverage($status->schoolyear,$status->level,array(0),0,3,$grades)}}</td>
								<td>{{GradeComputation::computeQuarterAverage($status->schoolyear,$status->level,array(0),0,4,$grades)}}</td>
								<td>{{GradeComputation::computeQuarterAverage($status->schoolyear,$status->level,array(0),0,5,$grades)}}</td>
							</tr>
							
						</table>
					</div>
				</div>
				@endif
				<!--Academic Grades Box-->

				<!--Technical Grades Box-->
				@if(in_array(1,$subjecttypes))
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Technical Subjects</h3>
					</div>
					<div class='box-body table-responsive no-padding'>
						<table class="table table-striped" style="font-size:9.5pt;text-align: center">
							<thead>
							<tr>
								<th style="text-align: left">Subject</th>
								<th>1st</th>
								<th>2nd</th>
								<th>3rd</th>
								<th>4th</th>
								<th>Final Grade</th>
								</tr>
							</thead>
							@foreach($grades as $subject)
							@if($subject->subjecttype == 1)
							<?php $gradeSetting = App\GradesSetting::where('subjecttype',$subject->subjecttype)->where('schoolyear',$sy->schoolyear)->first();?>
							<tr>
								<td style="text-align: left">{{$subject->subjectname}}</td>
								<td>{{$subject->first_grading != 0 ?round($subject->first_grading,$gradeSetting->decimal):""}}</td>
								<td>{{$subject->second_grading != 0 ?round($subject->second_grading,$gradeSetting->decimal):""}}</td>
								<td>{{$subject->third_grading != 0 ?round($subject->third_grading,$gradeSetting->decimal):""}}</td>
								<td>{{$subject->fourth_grading != 0 ?round($subject->fourth_grading,$gradeSetting->decimal):""}}</td>
								<td>{{$subject->final_grade != 0 ?round($subject->final_grade,$gradeSetting->decimal):""}}</td>
							</tr>
							@endif
							@endforeach
							<tr>
								<td style="text-align: left">ACADEMIC AVERAGE</td>
								<td>{{GradeComputation::computeQuarterAverage($status->schoolyear,$status->level,array(0),0,1,$grades)}}</td>
								<td>{{GradeComputation::computeQuarterAverage($status->schoolyear,$status->level,array(0),0,2,$grades)}}</td>
								<td>{{GradeComputation::computeQuarterAverage($status->schoolyear,$status->level,array(0),0,3,$grades)}}</td>
								<td>{{GradeComputation::computeQuarterAverage($status->schoolyear,$status->level,array(0),0,4,$grades)}}</td>
								<td>{{GradeComputation::computeQuarterAverage($status->schoolyear,$status->level,array(0),0,5,$grades)}}</td>
							</tr>
							
						</table>
					</div>
				</div>
				@endif
				<!--Technical Grades Box-->
			</div>
			<!--Column 1-->

			<!--Column 2-->
			<div class="col-md-6">
				<!--Conduct Box-->
				@if(in_array(3,$subjecttypes))
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Conducts</h3>
					</div>
					<div class='box-body table-responsive no-padding'>
						<table class="table table-striped" style="font-size:9.5pt;text-align: center">
							<thead>
							<tr>
								<th style="text-align: left">Conduct</th>
								<th>Point</th>
								<th>1st</th>
								<th>2nd</th>
								<th>3rd</th>
								<th>4th</th>
								</tr>
							</thead>
							@foreach($grades as $subject)
							@if($subject->subjecttype == 3)
							<?php $gradeSetting = App\GradesSetting::where('subjecttype',$subject->subjecttype)->where('schoolyear',$sy->schoolyear)->first();?>
							<tr>
								<td style="text-align: left">{{$subject->subjectname}}</td>
								<td><b>{{$subject->points}}</b></td>
								<td>{{$subject->first_grading != 0 ?round($subject->first_grading,$gradeSetting->decimal):""}}</td>
								<td>{{$subject->second_grading != 0 ?round($subject->second_grading,$gradeSetting->decimal):""}}</td>
								<td>{{$subject->third_grading != 0 ?round($subject->third_grading,$gradeSetting->decimal):""}}</td>
								<td>{{$subject->fourth_grading != 0 ?round($subject->fourth_grading,$gradeSetting->decimal):""}}</td>
							</tr>
							@endif
							@endforeach
							<tr>
								<td style="text-align: left">AVERAGE</td>
								<td><b>100</b></td>
								<td>{{GradeComputation::computeQuarterAverage($status->schoolyear,$status->level,array(3),0,1,$grades)}}</td>
								<td>{{GradeComputation::computeQuarterAverage($status->schoolyear,$status->level,array(3),0,2,$grades)}}</td>
								<td>{{GradeComputation::computeQuarterAverage($status->schoolyear,$status->level,array(3),0,3,$grades)}}</td>
								<td>{{GradeComputation::computeQuarterAverage($status->schoolyear,$status->level,array(3),0,4,$grades)}}</td>
							</tr>
							<tr>
								<td style="text-align: left"><b>FINAL AVERAGE</b></td>
								<td colspan="4">{{GradeComputation::computeQuarterAverage($status->schoolyear,$status->level,array(3),0,5,$grades)}}</td>
							</tr>
						</table>
					</div>
				</div>
				@endif
				<!--Conduct Box-->
			</div>
			<!--Column 2-->

			<!--Full Column-->
			<div class="col-md-12">
				<!--Attendance Box-->
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Attendance</h3>
					</div>
					<div class='box-body table-responsive no-padding'>
						<table class="table table-striped" style="font-size:9.5pt;text-align: center">
							<!--Attendace table header-->
							<thead>
							<tr style="text-align: center">
								<th>ATTENDANCE</th>
								<th style="text-align: center">Jun</th>
								<th style="text-align: center">Jul</th>
								<th style="text-align: center">Aug</th>
								<th style="text-align: center">Sept</th>
								<th style="text-align: center">Oct</th>
								<th style="text-align: center">Nov</th>
								<th style="text-align: center">Dec</th>
								<th style="text-align: center">Jan</th>
								<th style="text-align: center">Feb</th>
								<th style="text-align: center">Mar</th>
								<th style="text-align: center">Total</th>
								</tr>
							</thead>
							<!--Attendace table header-->
							<!--Attendace days of school-->
							<tr>
								<td style="text-align: left">Days Of School</td>
								<td>{{$jun != 0 ? $jun:""}}</td>
								<td>{{$jul != 0 ? $jul:""}}</td>
								<td>{{$aug != 0 ? $aug:""}}</td>
								<td>{{$sept != 0 ? $sept:""}}</td>
								<td>{{$oct != 0 ? $oct:""}}</td>
								<td>{{$nov != 0 ? $nov:""}}</td>
								<td>{{$dec != 0 ? $dec:""}}</td>
								<td>{{$jan != 0 ? $jan:""}}</td>
								<td>{{$feb != 0 ? $feb:""}}</td>
								<td>{{$mar != 0 ? $mar:""}}</td>
								<td>{{$mar != 0 || $status->status == 3 ? $mar:""}}</td>
							</tr>
							<!--Attendace days of school-->
							<!--Attendace dayp,dayt,daya-->
							@foreach($attendances as $attendance)
							<tr>
								<td style="text-align: left">{{$attendance->attendanceName}}</td>
								<td>{{$jun != 0 ? number_format($attendance->Jun,1):""}}</td>
								<td>{{$jul != 0 ? number_format($attendance->Jul,1):""}}</td>
								<td>{{$aug != 0 ? number_format($attendance->Aug,1):""}}</td>
								<td>{{$sept != 0 ? number_format($attendance->Sept,1):""}}</td>
								<td>{{$oct != 0 ? number_format($attendance->Oct,1):""}}</td>
								<td>{{$nov != 0 ? number_format($attendance->Nov,1):""}}</td>
								<td>{{$dec != 0 ? number_format($attendance->Dece,1):""}}</td>
								<td>{{$jan != 0 ? number_format($attendance->Jan,1):""}}</td>
								<td>{{$feb != 0 ? number_format($attendance->Feb,1):""}}</td>
								<td>{{$mar != 0 ? number_format($attendance->Mar,1):""}}</td>
								<td>
								{{$mar != 0 || $status->status == 3 ? $attendance->Mar:""}}
								</td>
							</tr>
							@endforeach
							<!--Attendace dayp,dayt,daya-->
						</table>
					</div>
				</div>
				<!--Attendance Box-->
			</div>
			<!--Full Column-->
		</div>
	</section>
@stop
@else
@section('content')
<section class="content">
	<div class="row">
	<!--!st Semester-->
	<div class="box box-default">
		<div class="box-header with-border">
			<h3 class="box-title">1st Semester</h3>

			<div class="box-tools pull-right">
			<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
			</button>
			</div>
			<!-- /.box-tools -->
	    </div>
		<div class="box-body">
			<div class="col-md-6">
				<!--Academic Grades Box-->
				@if(in_array(5,$subjecttypes))
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Subjects</h3>
					</div>
					<div class='box-body table-responsive no-padding'>
						<table class="table table-striped" style="font-size:9.5pt;text-align: center">
							<thead>
							<tr>
								<th style="text-align: left">Subject</th>
								<th>1st</th>
								<th>2nd</th>
								<th>Final Grade</th>
								</tr>
							</thead>
							@foreach($grades as $subject)
							@if($subject->subjecttype == 5)
							<?php $gradeSetting = App\GradesSetting::where('subjecttype',$subject->subjecttype)->where('schoolyear',$sy->schoolyear)->first();?>
							<tr>
								<td style="text-align: left">{{$subject->subjectname}}</td>
								<td>{{$subject->first_grading != 0 ?round($subject->first_grading,$gradeSetting->decimal):""}}</td>
								<td>{{$subject->second_grading != 0 ?round($subject->second_grading,$gradeSetting->decimal):""}}</td>
								<td>{{$subject->final_grade != 0 ?round($subject->final_grade,$gradeSetting->decimal):""}}</td>
							</tr>
							@endif
							@endforeach
							<tr>
								<td style="text-align: left">ACADEMIC AVERAGE</td>
								<td>{{GradeComputation::computeQuarterAverage($status->schoolyear,$status->level,array(0),0,1,$grades)}}</td>
								<td>{{GradeComputation::computeQuarterAverage($status->schoolyear,$status->level,array(0),0,2,$grades)}}</td>
								<td>{{GradeComputation::computeQuarterAverage($status->schoolyear,$status->level,array(0),0,3,$grades)}}</td>
								<td>{{GradeComputation::computeQuarterAverage($status->schoolyear,$status->level,array(0),0,4,$grades)}}</td>
								<td>{{GradeComputation::computeQuarterAverage($status->schoolyear,$status->level,array(0),0,5,$grades)}}</td>
							</tr>
							
						</table>
					</div>
				</div>
				@endif
				<!--Academic Grades Box-->
	    </div>
	</div>
	<!--!st Semester-->
	</div>
</section>
@stop
@endif

@section('java')
	$('#gradesmenu').addClass("active");
@stop