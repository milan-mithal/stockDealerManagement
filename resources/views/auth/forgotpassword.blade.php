@extends('auth.layout')

@section('content')
<form class="login100-form validate-form" action="{{ route('forgotpasswordauthenticate') }}" method="post">
@csrf
									<span class="login100-form-title">
										Forgot Password
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
									<div class="container-login100-form-btn">
										<button type="submit" class="login100-form-btn btn-primary">
											Reset Password
										</button>
									</div>
									<div class="text-center pt-3">
										<p class="text-dark mb-0">Know your credentials?<a href="{{ route('login') }}" class="text-primary ms-1">Login Here</a></p>
									</div>
								</form>
@endsection