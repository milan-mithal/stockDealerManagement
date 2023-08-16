@extends('auth.layout')

@section('content')
<form class="login100-form validate-form" action="{{ route('store') }}" method="post">
    @csrf
    <span class="login100-form-title">
        Registration
    </span>
    <div class="wrap-input100 validate-input" data-bs-validate = "Valid email is required: ex@abc.xyz">
        <input class="input100" type="text" name="email" placeholder="User name">
        <span class="focus-input100"></span>
        <span class="symbol-input100">
            <i class="mdi mdi-account" aria-hidden="true"></i>
        </span>
    </div>
    <div class="wrap-input100 validate-input" data-bs-validate = "Valid email is required: ex@abc.xyz">
        <input class="input100" type="text" name="email" placeholder="Email">
        <span class="focus-input100"></span>
        <span class="symbol-input100">
            <i class="zmdi zmdi-email" aria-hidden="true"></i>
        </span>
    </div>
    <div class="wrap-input100 validate-input" data-bs-validate = "Password is required">
        <input class="input100" type="password" name="pass" placeholder="Password">
        <span class="focus-input100"></span>
        <span class="symbol-input100">
            <i class="zmdi zmdi-lock" aria-hidden="true"></i>
        </span>
    </div>
    <label class="custom-control custom-checkbox mt-4">
        <input type="checkbox" class="custom-control-input">
        <span class="custom-control-label">Agree the <a href="terms.html">terms and policy</a></span>
    </label>
    <div class="container-login100-form-btn">
        <a href="index.html" class="login100-form-btn btn-primary">
            Register
        </a>
    </div>
    <div class="text-center pt-3">
        <p class="text-dark mb-0">Already have account?<a href="login.html" class="text-primary ms-1">Sign In</a></p>
    </div>
</form>
@endsection