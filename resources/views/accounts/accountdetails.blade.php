@extends('layouts.app')
<?php
	$totalamount = 0;
	$totalpayment = 0;
	$totaldiscount = 0;
	$totaldm = 0;
	$totalbalance = 0;
?>
@section('header')
	<section class="content-header">
		<h1>Account Details</h1>
		<ol class="breadcrumb">
		  <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
		  <li class="active">Account</li>
		  <li class="active">Details</li>
		</ol>
	</section>
@stop

@section('content')
	<section class="content">
		<!--Row 1-->
		<div class='row'>
			<div class='col-md-4'>
				<div class='box box-success'>
					<div class="box-header with-border">
						<h3 class="box-title">Schedule of Payment</h3>
					</div>
					<div class='box-body table-responsive no-padding'>
						<table class='table table-striped' style='text-align: left'>
							<tr style='text-align: center'>
								<td>Due Date</td>
								<td>Amount</td>
							</tr>
							@foreach($paymentScheds as $paymentSched)
							<tr>
								<td>
								@if($paymentSched->pluck('duetype')->last() == '0')
								Upon Enrollment
								@else
								{{$paymentSched->pluck('duedate')->last()}}
								@endif
								</td>
								<td style='text-align: right'>{{number_format(round($paymentSched->sum('amount'),2),2)}}</td>
							</tr>
							@endforeach
						</table>
					</div>
				</div>
			</div>
			<div class='col-md-8'>
				<div class='box box-success'>
					<div class="box-header with-border">
						<h3 class="box-title">Other Accounts</h3>
					</div>
					<div class='box-body table-responsive no-padding'>
						<table class='table table-striped'>
							<tr>
								<td>Account</td>
								<td>Amount</td>
								<td>Details</td>
							</tr>
							@foreach($others as $other)
								@if((round($other->amount,2)-(round($other->payment,2)+round($other->debitmemo,2))))
								<tr>
									<td>{{$other->acctcode}}</td>
									<td>{{$other->amount}}</td>
								</tr>
								@endif
							@endforeach
						</table>
					</div>
				</div>
			</div>
		</div>
		<!--Row 1-->

		<!--Row 2-->
		<div class="row">
			<div class='col-md-12'>
				<!--Account Ledger-->
				<div class='box box-warning'>
					<div class="box-header with-border">
						<h3 class="box-title">Ledger</h3>
					</div>
					<div class='box-body table-responsive no-padding'>
						<table class='table table-striped'>
							<tr>
								<td>Description</td>
								<td>Amount</td>
								<td>Discount</td>
								<td>DM</td>
								<td>Payment</td>
								<td>Balance</td>
							</tr>
							@foreach($currents as $current)
							<?php
							$amount = round($current->sum('amount'),2);
							$payment = round($current->sum('payment'),2);
							$discount = round($current->sum('plandiscount'),2) + round($current->sum('otherdiscount'),2);
							$dm = round($current->sum('debitmemo'),2);
							$balance = $amount - ($payment+$discount+$dm);

							$totalamount = $totalamount + $amount;
							$totalpayment = $totalpayment + $payment;
							$totaldiscount = $totaldiscount + $discount;
							$totaldm = $totaldm + $dm;
							$totalbalance = $totalbalance + $balance;
							?>
							<tr>
								<td>{{$current->pluck('acctcode')->last()}}</td>
								<td>{{number_format($amount,2)}}</td>
								<td>{{number_format($discount,2)}}</td>
								<td>{{number_format($dm,2)}}</td>
								<td>{{number_format($payment,2)}}</td>
								<td>{{number_format($balance,2)}}</td>
							</tr>
							@endforeach
							<tr>
								<td>Total</td>
								<td>{{number_format($totalamount,2)}}</td>
								<td>{{number_format($totaldiscount,2)}}</td>
								<td>{{number_format($totaldm,2)}}</td>
								<td>{{number_format($totalpayment,2)}}</td>
								<td>{{number_format($totalbalance,2)}}</td>
							</tr>
						</table>
					</div>
				</div>
				<!--Account Details-->
			</div>
		</div>
		<!--Row 2-->
	</section>
@foreach($currents as $current)


<br>
@endforeach
@stop

@section('java')
	$('#accountsmenu').addClass("active menu-down");
	$('#accountDetails').addClass("active");
@stop