@extends('layouts.auth')

@section('content')
<section class="content-header">
  <h1><i class="fa fa-question" aria-hidden="true"></i>  Solaris</h1>
</section>

<section class="content">
    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('idno') ? ' has-error' : '' }}">
            <div class="col-md-12">
                <input id="idno" type="text" class="form-control" placeholder="User Id" name="idno" value="{{ old('email') }}" required autofocus>

                @if ($errors->has('idno'))
                    <span class="help-block">
                        <strong>{{ $errors->first('idno') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <div class="col-md-12">
                <input id="password" type="password" class="form-control" placeholder="Password" name="password" required>

                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-8">
                <button type="submit" class="btn btn-primary col-md-8">
                    Login
                </button>
            </div>
            <div>
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    Forgot Your Password?
                </a>
            </div>
        </div>
    </form>
</section>
@endsection
