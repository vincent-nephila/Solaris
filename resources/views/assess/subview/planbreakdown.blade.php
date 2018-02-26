<?php
use App\Http\Controllers\StudentInfo as Info;
use App\Http\Controllers\Helper as MainHelper;

$sy = MainHelper::get_enrollmentSY();

?>
<table class='table table-bordered'>
    <tr>
        <td>Description</td>
        <td>Amount</td>
    </tr>
    <tr>
        <td>Total Fee</td>
        <td align='right'>{{number_format($mainaccounts->sum('amount'),2)}}</td>
    </tr>
    @foreach($mainaccounts->groupBy('accountingcode') as $accounts)
    <tr>
        <td>{{$accounts->pluck('acctcode')->last()}}</td>
        <td align='right'>{{number_format($accounts->sum('amount'),2)}}</td>
    </tr>
    @endforeach
    <tr>
        <td>Less: Plan Discount</td>
        <td align='right'>{{number_format($mainaccounts->sum('discount')+$mainaccounts->sum('plandiscount'),2)}}</td>
    </tr>
    <tr>
        <td>Total</td>
        <td align='right'>{{number_format($mainaccounts->sum('amount') - $mainaccounts->sum('discount')-$mainaccounts->sum('plandiscount'),2)}}</td>
    </tr>
</table>
@if(Info::get_status(Auth::user()->idno, $sy) == 0)
<h5>Books</h5>
<table class="table table-bordered">
    <tr>
        <td></td>
        <td><div id="check_uncheck"><p  style="cursor:pointer" id="select_all" onclick="unselect_all()">Uncheck All</p></div></td>
        <td>Amount</td>
    </tr>
    @foreach($books as $book)
    <tr>
        <td><input type="checkbox" class="books" name="books[]" value="{{$book->id}}" checked="checked"></td>
        <td>{{$book->subsidiary}}</td>
        <td>{{$book->amount}}</td>
    </tr>
    @endforeach
    
</table>

<button type="submit" class='col-md-12 btn btn-success'>Process</button>
@endif

@if(Info::get_status(Auth::user()->idno, $sy) == 1)
<form method='POST' action='{{route("reassess")}}'>
{{ csrf_field() }}
<button type='submit' class='btn btn-success col-md-6'>Re-assess</button>
</form>
<a href="{{route('printassessment')}}" class='btn btn-danger col-md-6'>Print Assessment</a>
@endif