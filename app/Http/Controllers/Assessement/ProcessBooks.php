<?php

namespace App\Http\Controllers\Assessement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Http\Controllers\Helper as MainHelper;

class ProcessBooks extends Controller
{
    static function processBooks($books,$idno){
        $schoolyear = MainHelper::get_enrollmentSY();
        foreach ($books as $book){
            $newBook = \App\CtrBook::find($book);
            
            if($newBook){
                $newRecord = static::addToLedger($newBook,$idno,$schoolyear);
                static::addToBooks($newRecord);
            }
        }
    }
    
    static function addToLedger($newBook,$idno,$schoolyear){
            $newRecord = new \App\Ledger();
            $newRecord->idno = $idno;
            $newRecord->transactiondate = Carbon::now();
            $newRecord->department = MainHelper::get_levelDept($newBook->level);
            $newRecord->level = $newBook->level;
            $newRecord->course = $newBook->strand;
            $newRecord->strand= $newBook->strand;
            $newRecord->categoryswitch = $newBook->categoryswitch;
            $newRecord->accountingcode = $newBook->acctcode;
            $newRecord->acctcode = $newBook->acctname;
            $newRecord->description =$newBook->subsidiary;
            $newRecord->receipt_details = $newBook->receipt_details;
            $newRecord->amount = $newBook->amount;

            $newRecord->acct_department = $newBook->acct_department;
            $newRecord->sub_department = $newBook->sub_department;
            $newRecord->schoolyear = $schoolyear;
            $newRecord->duetype = 0;
            $newRecord->duedate = $newBook->duedate;
            $newRecord->postedby = $idno;
            $newRecord->save();
            
            return $newRecord;
    }
    
    static  function addToBooks($newRecord){
        $newBook = new \App\StudentBooks();
        $newBook->refno = $newRecord->id;
        $newBook->idno = $newRecord->idno;
        $newBook->book_title = $newRecord->description;
        $newBook->schoolyear = $newRecord->schoolyear;
        $newBook->save();
        
        
        
    }
}
