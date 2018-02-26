<?php

namespace App\Http\Controllers\Accounts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Helper extends Controller
{
    static function studentLedger($idno,$sy){
        return \App\Ledger::where('idno',$idno)->where('schoolyear',$sy)->orderBy('categoryswitch','ASC')->orderBy('duedate','ASC')->get();
    }
}
