@extends('common.layout')

@section('content')
<!--app-content open-->
				<div class="app-content main-content mt-0">
					<div class="side-app">
						<!-- CONTAINER -->
						<div class="main-container container-fluid">

							<!-- PAGE-HEADER -->
							<div class="page-header">
								<div>
									<h1 class="page-title">Edit User</h1>
								</div>
								<div class="ms-auto pageheader-btn">
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="javascript:void(0);">User</a></li>
										<li class="breadcrumb-item active" aria-current="page">Edit</li>
									</ol>
								</div>
							</div>
							<!-- PAGE-HEADER END -->

							<!-- row -->
							<div class="row row-deck">
								<div class="col-lg-12 col-md-">
										<div class="card custom-card">
											
												
											
											<div class="card-body">
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
												<p class="text-muted">Here you can edit user</p>
                                                
												<div class="d-flex flex-column">
                                                    <form method="post" name="frm" id="frm" action="{{ route('user.update', $userDetails->id) }}" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label for="formFile" class="form-label">Name</label>
                                                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $userDetails->name) }}">
                                                            @error('name')
                                                              <div class="invalid-feedback block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="formFile" class="form-label">User Email Id</label>
                                                            <input class="form-control" type="text" name="email" id="email" value="{{ old('email', $userDetails->email) }}">
                                                            @error('email')
                                                              <div class="invalid-feedback block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="formFile" class="form-label">User Company Name</label>
                                                            <input class="form-control" type="text" name="dealer_name" id="dealer_name" value="{{ old('dealer_name', $userDetails->dealer_name) }}">
                                                            @error('dealer_name')
                                                              <div class="invalid-feedback block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="formFile" class="form-label">User Company Address</label>
                                                            <textarea class="form-control" type="text" name="address" id="address">{{ old('address', $userDetails->address) }}</textarea>
                                                            @error('address')
                                                              <div class="invalid-feedback block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="formFile" class="form-label">User Phone No.</label>
                                                            <input class="form-control" type="text" name="phone_no" id="phone_no" value="{{ old('phone_no', $userDetails->phone_no) }}">
                                                            @error('phone_no')
                                                            <div class="invalid-feedback block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="formFile" class="form-label">User Region</label>
                                                            <input class="form-control" type="text" name="region" id="region" value="{{ old('region', $userDetails->region) }}">
                                                            @error('region')
                                                            <div class="invalid-feedback block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="formFile" class="form-label">User Community</label>
                                                            <input class="form-control" type="text" name="community" id="community" value="{{ old('community', $userDetails->community) }}">
                                                            @error('community')
                                                            <div class="invalid-feedback block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="formFile" class="form-label">Role</label>
                                                            <select class="form-control" name="role" id="role">
                                                                <option value="">Choose Role</option>
                                                                @foreach(App\Enums\UserRolesEnums::values() as $key=>$value)
                                                                    <option value="{{ $key }}" @selected(old('role', $userDetails->role) == $key)>{{ $value }}</option>
                                                                @endforeach
                                                              </select>
                                                              @error('role')
                                                              <div class="invalid-feedback block">{{ $message }}</div>
                                                              @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="formFile" class="form-label">Status</label>
                                                            <select class="form-control" name="status" id="status">
                                                                <option value="">Choose Status</option>
                                                                @foreach(App\Enums\UserStatusEnums::values() as $key=>$value)
                                                                    <option value="{{ $key }}" @selected(old('status',$userDetails->status) == $key)>{{ $value }}</option>
                                                                @endforeach
                                                              </select>
                                                              @error('status')
                                                              <div class="invalid-feedback block">{{ $message }}</div>
                                                              @enderror
                                                        </div>
                                                        <button type="submit" name="submit" id="submit" class="btn ripple btn-primary">Submit</button>
                                                    </form>
												</div>
											</div>
										</div>
								</div>
							
							</div>
							<!-- /row -->

						



						</div>
					</div>
				</div>
				<!-- CONTAINER CLOSED -->
@endsection