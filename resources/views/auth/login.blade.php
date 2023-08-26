@extends('auth.layout')

@section('content')
<form class="login100-form validate-form" action="{{ route('authenticate') }}" method="post">
@csrf
									<span class="login100-form-title">
										Login
									</span>
									@if(Session::has('success'))
                                                <div class="card-header border-bottom">
                                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                        {{ Session::get('success') }}
                                                        @php
                                                            Session::forget('success');
                                                        @endphp
                                                    </div>
                                                </div>
                                                @endif
                                                @if(Session::has('error'))
                                                <div class="card-header border-bottom">
                                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                        {{ Session::get('error') }}
                                                        @php
                                                            Session::forget('error');
                                                        @endphp
                                                    </div>
                                                </div>
                                                @endif
									<div class="wrap-input100 validate-input" data-bs-validate = "Valid email is required: ex@abc.xyz">
										<input class="input100 @error('email') is-invalid state-invalid @enderror" type="text" name="email" placeholder="Email" value="{{ old('email') }}">
										<span class="symbol-input100">
											<i class="zmdi zmdi-email" aria-hidden="true"></i>
										</span> 
										
									</div>
									@if ($errors->has('email'))
                                            <div class="text-danger my-2">{{ $errors->first('email') }}</div>
                                        @endif
									<div class="wrap-input100 validate-input" data-bs-validate = "Password is required">
										<input class="input100 @error('password') is-invalid state-invalid @enderror" type="password" id="password" name="password" placeholder="Password">
										<span class="symbol-input100">
											<i class="zmdi zmdi-lock" aria-hidden="true"></i>
										</span>
									</div>
									@if ($errors->has('password'))
									<div class="text-danger my-2">{{ $errors->first('password') }}</div>
								@endif
									<div class="text-end pt-1">
										<p class="mb-0"><a href="forgot-password.html" class="text-primary ms-1">Forgot Password?</a></p>
									</div>
									<div class="container-login100-form-btn">
										<button type="submit" class="login100-form-btn btn-primary">
											Login
										</button>
									</div>
									<div class="text-center pt-3">
										<p class="text-dark mb-0">Not a member?<a href="register.html" class="text-primary ms-1">Create an Account</a></p>
									</div>
								</form>
@endsection