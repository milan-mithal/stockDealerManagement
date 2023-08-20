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
                    <h1 class="page-title">View/Order Products</h1>
                </div>
                <div class="ms-auto pageheader-btn">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Dealer</a></li>
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
												<table class="table editable-table table-bordered text-nowrap border-bottom" id="basic-datatable">
													<thead>
														<tr>
															<th class="wd-10p border-bottom-0">Code</th>
															<th class="wd-10p border-bottom-0">Category</th>
                                                            <th class="wd-10p border-bottom-0">Product Name</th>
															<th class="wd-10p border-bottom-0">Image</th>
															<th class="wd-10p border-bottom-0">Size</th>
															<th class="wd-10p border-bottom-0">Price (AED)</th>
                                                            <th class="wd-10p border-bottom-0">Total Stock Available</th>
                                                            <th class="wd-10p border-bottom-0">Order Stock</th>
														</tr>
													</thead>
													<tbody>
                                                        @foreach ($allProductList as $productDetails)
														<tr>
															<td>{{$productDetails->product_code}}</td>
                                                            <td>{{$productDetails->product_category}}</td>
															<td>{{$productDetails->product_name}}</td>
															<td><img class="hpx-100" src="{{ url($productDetails->product_image)}}" /></td>
															<td>{{$productDetails->product_size}}</td>
															<td>{{$productDetails->product_price}}</td>
                                                            <td>{{$productDetails->total_stock_qty - $productDetails->total_stock_sold_qty}}</td>
                                                            <td><input type="number" class="wp-50" id="order_qty_{{ $productDetails->id }}" value="{{$productDetails->ordered_qty}}" placeholder="0">
                                                                <button type="button" class="btn btn-icon  btn-primary" data-bs-placement="top" data-bs-toggle="tooltip" data-bs-original-title="Add To Cart" id="addToCart_{{ $productDetails->id }}" data-qty="{{$productDetails->total_stock_qty - $productDetails->total_stock_sold_qty}}" data-url="{{ route('dealerorder.store') }}" onClick="addToCart({{ $productDetails->id }})"><i class="fe fe-check"></i></button>
                                                                
                                                                <button type="button" class="btn btn-icon  btn-danger" data-bs-placement="top" data-bs-toggle="tooltip" data-bs-original-title="Remove From Cart" id="removeFromCart_{{ $productDetails->id }}" data-url="{{ route('dealerorder.destroy') }}" onClick="removeFromCart({{ $productDetails->id }})"><i class="fe fe-x"></i></button>

                                                                <div class="valid-feedback block text-bold mb-2" id="successCart_{{ $productDetails->id }}"></div>
                                                                <div class="invalid-feedback block text-bold mb-2" id="errorCart_{{ $productDetails->id }}"></div>
                                                            </td>
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