<?php

namespace App\Http\Controllers\Accounts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DetailsController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    }

    function index(){
    	$user = \Auth::user();
    	$sy = \App\CtrSchoolYear::first()->schoolyear;

    	$ledgers = \App\Ledger::where('idno',$user->idno)->orderBy('categoryswitch')->orderBy('duedate')->get();
    	$currents = $ledgers->where('schoolyear',$sy)->groupBy('accountingcode');
    	$paymentScheds = $ledgers->where('schoolyear',$sy)->where('categoryswitch','<=','6')->groupBy('duedate');
    	$others = $ledgers->where('categoryswitch',7);

    	return view('accounts.accountdetails',compact('currents','paymentScheds','others'));
    }
}
