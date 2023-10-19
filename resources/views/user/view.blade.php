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
                    @if (Auth::user()->role == 'dealer')
                            Manger Sub Dealer
                            @else
                            Manager Users
                            @endif
                </div>
                <div class="ms-auto pageheader-btn">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Users</a></li>
                        <li class="breadcrumb-item active" aria-current="page">View</li>
                    </ol>
                </div>
            </div>
            <!-- PAGE-HEADER END -->


            <!-- Row -->
							<div class="row row-sm">
								<div class="col-lg-12">
									<div class="card">
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
										<div class="card-body">
											<div class="table-responsive">
												<table class="table table-bordered text-nowrap border-bottom" id="basic-datatable">
													<thead>
														<tr>
															<th class="wd-15p border-bottom-0">Code</th>
															<th class="wd-15p border-bottom-0">Name</th>
                                                            <th class="wd-15p border-bottom-0">Email</th>
                                                            @if (Auth::user()->role == 'dealer')
                                                            <th class="wd-15p border-bottom-0">Percentage</th>
                                                            @endif
                                                            <th class="wd-15p border-bottom-0">Name</th>
                                                            <th class="wd-20p border-bottom-0">Address</th>
                                                            <th class="wd-20p border-bottom-0">Region</th>
                                                            <th class="wd-20p border-bottom-0">Community</th>
                                                            <th class="wd-20p border-bottom-0">Phone No.</th>
															<th class="wd-20p border-bottom-0">Role</th>
															<th class="wd-15p border-bottom-0">Status</th>
                                                            <th class="wd-25p border-bottom-0">Action</th>
														</tr>
													</thead>
													<tbody>
                                                        @foreach ($allUserList as $userDetails)
                                                        @if (Auth::user()->role != 'admin')
														<tr>
															<td>{{$userDetails->user_code}}</td>
                                                            <td>{{$userDetails->name}}</td>
															<td>{{$userDetails->email}}</td>
                                                            @if (Auth::user()->role == 'dealer')
                                                            <td>{{$userDetails->percentage}}%</td>
                                                            @endif
                                                            <td>{{$userDetails->dealer_name}}</td>
															<td>{{$userDetails->address}}</td>
                                                            <td>{{$userDetails->region}}</td>
															<td>{{$userDetails->community}}</td>
                                                            <td>{{$userDetails->phone_no}}</td>
                                                            <td>{{ ucfirst($userDetails->role) }}</td>
                                                            <td>@if ($userDetails->status == 'active')
                                                                <a href="javascript:void(0)" class="btn btn-primary-gradient">Active</a>
                                                                @endif
                                                                @if ($userDetails->status == 'inactive')
                                                                <a href="javascript:void(0)" class="btn btn-danger-gradient">Blocked</a>
                                                                @endif</td>
                                                            <td>
                                                                <a href="{{ route('user.edit', $userDetails->id) }}"><button type="button" class="btn btn-icon  btn-primary"><i class="fe fe-edit"></i></button></a>
                                                            </td>
														</tr>
                                                        @else 
                                                        <tr>
															<td><a href="{{ route('user.subdealer', $userDetails->id) }}">{{$userDetails->user_code}}</a></td>
                                                            <td>{{$userDetails->name}}</td>
															<td>{{$userDetails->email}}</td>
                                                            <td>{{$userDetails->dealer_name}}</td>
															<td>{{$userDetails->address}}</td>
                                                            <td>{{$userDetails->region}}</td>
															<td>{{$userDetails->community}}</td>
                                                            <td>{{$userDetails->phone_no}}</td>
                                                            <td>{{ ucfirst($userDetails->role) }}</td>
                                                            <td>@if ($userDetails->status == 'active')
                                                                <a href="javascript:void(0)" class="btn btn-primary-gradient">Active</a>
                                                                @endif
                                                                @if ($userDetails->status == 'inactive')
                                                                <a href="javascript:void(0)" class="btn btn-danger-gradient">Blocked</a>
                                                                @endif</td>
                                                            <td>
                                                                <a href="{{ route('user.edit', $userDetails->id) }}"><button type="button" class="btn btn-icon  btn-primary"><i class="fe fe-edit"></i></button></a>
                                                            </td>
														</tr>
                                                        @endif
                                                        @endforeach
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- End Row -->

    

        </div>
    </div>
</div>
<!-- CONTAINER CLOSED -->
@endsection