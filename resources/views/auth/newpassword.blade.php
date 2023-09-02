@extends('auth.layout')

@section('content')
<form class="login100-form validate-form" action="{{ route('storenewpassword') }}" method="post">
@csrf
									<span class="login100-form-title">
										Create New Password
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
                                                <div class="wrap-input100 validate-input" data-bs-validate = "Password is required">
                                                    <input class="input100 @error('password') is-invalid state-invalid @enderror" type="password" id="password" name="password" placeholder="Password">
                                                    <span class="symbol-input100">
                                                        <i class="zmdi zmdi-lock" aria-hidden="true"></i>
                                                    </span>
                                                </div>
                                                @if ($errors->has('password'))
                                                <div class="text-danger my-2">{{ $errors->first('password') }}</div>
                                                @endif
									<div class="wrap-input100 validate-input" data-bs-validate = "Password is required">
										<input class="input100 @error('password_confirmation') is-invalid state-invalid @enderror" type="password" id="password_confirmation" name="password_confirmation" placeholder="Retype-Password">
										<span class="symbol-input100">
											<i class="zmdi zmdi-lock" aria-hidden="true"></i>
										</span>
									</div>
									@if ($errors->has('password_confirmation'))
									<div class="text-danger my-2">{{ $errors->first('password_confirmation') }}</div>
								    @endif
									<div class="container-login100-form-btn">
										<button type="submit" class="login100-form-btn btn-primary">
											Submit
										</button>
									</div>
								</form>
@endsection