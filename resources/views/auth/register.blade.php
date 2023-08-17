@extends('auth.layout')

@section('content')
<form class="login100-form validate-form" action="{{ route('store') }}" method="post">
    @csrf
    <span class="login100-form-title">
        Registration
    </span>
    <div class="wrap-input100 validate-input" data-bs-validate = "Valid email is required: ex@abc.xyz">
        <input class="input100" type="text" id="name" name="name" value="{{ old('name') }}" placeholder="User name">
        <span class="focus-input100"></span>
        <span class="symbol-input100">
            <i class="mdi mdi-account" aria-hidden="true"></i>
        </span>
    </div>
    @if ($errors->has('name'))
                                <div class="text-danger">{{ $errors->first('name') }}</div>
                            @endif
    <div class="wrap-input100 validate-input" data-bs-validate = "Valid email is required: ex@abc.xyz">
        <input class="input100" type="text" id="email" name="email" value="{{ old('email') }}" placeholder="Email">
        <span class="focus-input100"></span>
        <span class="symbol-input100">
            <i class="zmdi zmdi-email" aria-hidden="true"></i>
        </span>
    </div>
    @if ($errors->has('email'))
                                <div class="text-danger">{{ $errors->first('email') }}</div>
                            @endif
    <div class="wrap-input100 validate-input" data-bs-validate = "Password is required">
        <input class="input100" type="password" id="password" name="password" placeholder="Password">
        <span class="focus-input100"></span>
        <span class="symbol-input100">
            <i class="zmdi zmdi-lock" aria-hidden="true"></i>
        </span>
    </div>
    @if ($errors->has('password'))
                                <div class="text-danger">{{ $errors->first('password') }}</div>
                            @endif
                            <div class="wrap-input100 validate-input" data-bs-validate = "Password is required">
                                <input class="input100" type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
                                <span class="focus-input100"></span>
                                <span class="symbol-input100">
                                    <i class="zmdi zmdi-lock" aria-hidden="true"></i>
                                </span>
                            </div>
                            @if ($errors->has('password'))
                                                        <div class="text-danger">{{ $errors->first('password') }}</div>
                                                    @endif
   
                                                    <div class="container-login100-form-btn">
                                                        <button type="submit" class="login100-form-btn btn-primary">
                                                            Register
                                                        </button>
                                                    </div>
    <div class="text-center pt-3">
        <p class="text-dark mb-0">Already have account?<a href="login.html" class="text-primary ms-1">Sign In</a></p>
    </div>
</form>
@endsection