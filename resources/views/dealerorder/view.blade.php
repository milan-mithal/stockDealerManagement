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
                    <h1 class="page-title">Order List</h1>
                </div>
                <div class="ms-auto pageheader-btn">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dealer</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Order List</li>
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
												<table class="table editable-table table-bordered text-nowrap border-bottom" id="basic-datatable">
                                                    <button id="button" class="btn btn-primary-gradient mb-4 data-table-btn" 
                                                    onClick="location.href = '{{ route('dealerorder.create') }}'">Place Order</button>
													<thead>
														<tr>
															<th class="wd-10p border-bottom-0">Code</th>
                                                            <th class="wd-10p border-bottom-0">Product Name</th>
															<th class="wd-10p border-bottom-0">Image</th>
															<th class="wd-10p border-bottom-0">Price (AED)</th>
                                                            <th class="wd-10p border-bottom-0">Order Stock</th>
														</tr>
													</thead>
													<tbody>
                                                        @foreach ($allCartList as $productDetails)
														<tr>
															<td>{{$productDetails->product_code}}</td>
															<td>{{$productDetails->product_name}}</td>
															<td><img class="hpx-100" src="{{ url($productDetails->product_image)}}" /></td>
															<td>{{$productDetails->product_price}}</td>
                                                            <td>{{$productDetails->order_quantity}}</td>
														</tr>
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