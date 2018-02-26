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

    	//Ledger Accounts
    	$ledgers = \App\Ledger::where('idno',$user->idno)->orderBy('categoryswitch')->orderBy('duedate')->get();
    	$currents = $ledgers->where('schoolyear',$sy)->groupBy('accountingcode');

        //Amount due computed on another function. Since, well it takes too long. Anyway suppose we should use a helper too for the computation.
        $amountDue = self::totaldue($ledgers);
    	$paymentScheds = $ledgers->where('schoolyear',$sy)->where('categoryswitch','<=','6')->groupBy('duedate');

    	//Transaction History
    	$transactions = \App\Dedit::where('idno',$user->idno)->where('paymenttype',1)->orderBy('id')->get();



    	return view('accounts.accountdetails',compact('currents','paymentScheds','others','transactions','amountDue','ledgers','sy'));
    }

    static function totaldue($ledgers){
        $dues = $ledgers->where('duedate','<=',date('Y-m-d',strtotime(\Carbon\Carbon::now())))->where('categoryswitch','<=',6);

        //Variable
        $totaldue = 0;
        $totalpaid = 0;

        foreach($dues as $due){
            $totaldue = $totaldue + $due->amount;
            $totalpaid = $totalpaid + ($due->payment + $due->plandiscount + $due->debitmemo + $due->otherdiscount);
        }
        return round($totaldue) - round($totalpaid);
    }
}
