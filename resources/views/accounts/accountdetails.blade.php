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
		<!--Other Accounts-->
			<div class='col-md-3 col-sm-6 col-xs-12'>
				<div class="small-box bg-green">
		            <div class="inner">
		              <h4>Other Accounts</h4>

		              <p>&nbsp;</p>
		            </div>
		            <div class="icon">
		              <i class="fa fa-plus" aria-hidden="true"></i>
		            </div>
		            <a href="#" class="small-box-footer">
		              More info <i class="fa fa-arrow-circle-right"></i>
		            </a>
	          	</div>
			</div>
		<!--Other Accounts-->

		<!--Account used-->
			<div class='col-md-3 col-sm-6 col-xs-12'>

				<div class="small-box bg-aqua">
		            <div class="inner">
		              <h4>John Vincent Villanueva</h4>

		              <p>Card Account</p>
		            </div>
		            <div class="icon">
		              <i class="fa fa-credit-card"></i>
		            </div>
		            <a href="#" class="small-box-footer">
		              More info <i class="fa fa-arrow-circle-right"></i>
		            </a>
	          	</div>

		  	</div>
		<!--Account used-->

		<!--Amount Due with payment Button-->
			<div class='col-md-offset-3 col-md-3 col-sm-6 col-xs-12'>
				<div class="small-box bg-red">
					<div class='info-box bg-red' style='margin-bottom:0px'>
						<span class='info-box-icon'>
							<i class="fa fa-info" aria-hidden="true"></i>
						</span>
						<div class='info-box-content'>
							<span class='info-box-text'>Amount Due</span>
							<span class='info-box-number'>{{number_format($amountDue,2)}}</span>
						</div>
					</div>
		            <a href="#" class="small-box-footer">
		              Process Payment
		            </a>
				</div>
			</div>
		<!--Amount Due with payment Button-->
		</div>
		<!--Row 1-->

		<!--Row 2-->
		<div class='row'>
			<div class='col-md-4'>
				<!--Payment Schedule-->
				<div class='box box-success'>
					<div class="box-header with-border">
						<h3 class="box-title">Schedule of Payment</h3>
					</div>
					<div class='box-body table-responsive no-padding'>
						<table class='table table-striped' style='text-align: left'>
							<tr style='text-align: center'>
								<td style='text-align: center'>Due Date</td>
								<td style='text-align: center'>Amount</td>
								<td></td>
							</tr>
							@foreach($paymentScheds as $paymentSched)
							<?php
								$amount = round($paymentSched->sum('amount'),2);
								$paid = round($paymentSched->sum('payment'),2) + round($paymentSched->sum('debitmemo'),2) +  round($paymentSched->sum('plandiscount'),2) +  round($paymentSched->sum('otherdiscount'),2);
							?>
							<tr>
								<td>
								@if($paymentSched->pluck('duetype')->last() == '0')
								Upon Enrollment
								@else
								{{date('M j, Y',strtotime($paymentSched->pluck('duedate')->last()))}}
								@endif
								</td>
								<td style='text-align: right'>
								<span
								@if($amount-$paid == 0)
								style="text-decoration: line-through;"
								@endif
								>{{number_format($amount,2)}}</span>
								</td>
								<td style='font-size: 7pt;color:red'>
									@if($amount-$paid == 0)
									Paid
									@endif
								</td>
							</tr>
							@endforeach
						</table>
					</div>
				</div>
				<!--Payment Schedule-->
			</div>
			<div class='col-md-8'>
				<!--Account Ledger-->
				<div class='box box-success'>
					<div class="box-header with-border">
						<h3 class="box-title">Ledger</h3>
					</div>
					<div class='box-body table-responsive no-padding'>
						<table class='table table-striped'>
							<tr style='text-align: center;'>
								<td style='text-align: left'>Description</td>
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
							<tr style='text-align: right'>
								<td style='text-align: left'>{{$current->pluck('acctcode')->last()}}</td>
								<td>{{number_format($amount,2)}}</td>
								<td>{{number_format($discount,2)}}</td>
								<td>{{number_format($dm,2)}}</td>
								<td>{{number_format($payment,2)}}</td>
								<td>{{number_format($balance,2)}}</td>
							</tr>
							@endforeach
							<tr style='text-align: right'>
								<td style='text-align: left'>Total</td>
								<td>{{number_format($totalamount,2)}}</td>
								<td>{{number_format($totaldiscount,2)}}</td>
								<td>{{number_format($totaldm,2)}}</td>
								<td>{{number_format($totalpayment,2)}}</td>
								<td>{{number_format($totalbalance,2)}}</td>
							</tr>
						</table>
					</div>
				</div>
				<!--Account Ledger-->
			</div>
		</div>
		<!--Row 2-->

		<!--Row 3-->
		<div class="row">
			<div class='col-md-6'>
				<div class='box box-warning'>
					<div class="box-header with-border">
						<h3 class="box-title">Main Transactions</h3>
					</div>
					<div class='box-body table-responsive no-padding'>
						<table class='table table-striped'>
							<tr>
								<td>Date</td>
								<td>OR Number</td>
								<td>Amount</td>
								<td>Status</td>
								<td>Details</td>
							</tr>
						
							@foreach($transactions as $transaction)
								@if($transaction->credit->pluck('categoryswitch')->last() != 9)
								<tr>
									<td>{{$transaction->transactiondate}}</td>
									<td>{{$transaction->receiptno}}</td>
									<td style="text-align: right">{{$transaction->amount}}</td>
									<td>
									@if($transaction->status == 0)
									OK
									@else
									Cancelled
									@endif
									</td>
									<td>
									@if($transaction->status == 0)
									<a href='#'>View</a>
									@endif
									</td>
								</tr>
								@endif
							@endforeach
						</table>
					</div>
				</div>
			</div>

			<div class='col-md-6'>
				<div class='box box-warning'>
					<div class="box-header with-border">
						<h3 class="box-title">Other Transactions</h3>
					</div>
					<div class='box-body table-responsive no-padding'>
						<table class='table table-striped' style='text-align: center'>
							<tr>
								<td>Date</td>
								<td>OR Number</td>
								<td>Amount</td>
								<td>Status</td>
								<td>Details</td>
							</tr>
						
							@foreach($transactions as $transaction)
								@if($transaction->credit->pluck('categoryswitch')->last() == 9)
								<tr>
									<td>{{$transaction->transactiondate}}</td>
									<td>{{$transaction->receiptno}}</td>
									<td style="text-align: right">{{$transaction->amount}}</td>
									<td>
									@if($transaction->status == 0)
									OK
									@else
									Cancelled
									@endif
									</td>
									<td>
									@if($transaction->status == 0)
									<a href='#'>View</a>
									@endif
									</td>
								</tr>
								@endif
							@endforeach
						</table>
					</div>
				</div>
			</div>
		</div>
		<!--Row 3-->
	</section>
@foreach($currents as $current)


<br>
@endforeach
@stop

@section('java')
	$('#accountsmenu').addClass("active menu-down");
	$('#accountDetails').addClass("active");
@stop