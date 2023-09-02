@extends('common.layout')
@section('content')
<!--app-content open-->
			<div class="app-content main-content mt-0">
				<div class="side-app">
					 <!-- CONTAINER -->
					 <div class="main-container container-fluid">
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
						<!-- PAGE-HEADER -->
						<div class="page-header">
							
							<div>
								<h1 class="page-title">Dashboard</h1>
							</div>
							<div class="ms-auto pageheader-btn">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
								</ol>
							</div>
						</div>
						<!-- PAGE-HEADER END -->

						<!-- ROW-1 -->
						<div class="row">
							<div class="col-lg-6 col-sm-12 col-md-6 col-xl-4">
								<div class="card overflow-hidden">
									<div class="card-body">
										<div class="row">
											<div class="col">
												<h3 class="mb-2 fw-semibold">{{ $totalOrders }}</h3>
												<p class="text-muted fs-13 mb-0">Total Orders</p>
											</div>
											<div class="col col-auto top-icn dash">
												<div class="counter-icon bg-secondary dash ms-auto box-shadow-secondary">
													<svg xmlns="http://www.w3.org/2000/svg" class="fill-white" enable-background="new 0 0 24 24" viewBox="0 0 24 24"><path d="M19.5,7H16V5.9169922c0-2.2091064-1.7908325-4-4-4s-4,1.7908936-4,4V7H4.5C4.4998169,7,4.4996338,7,4.4993896,7C4.2234497,7.0001831,3.9998169,7.223999,4,7.5V19c0.0018311,1.6561279,1.3438721,2.9981689,3,3h10c1.6561279-0.0018311,2.9981689-1.3438721,3-3V7.5c0-0.0001831,0-0.0003662,0-0.0006104C19.9998169,7.2234497,19.776001,6.9998169,19.5,7z M9,5.9169922c0-1.6568604,1.3431396-3,3-3s3,1.3431396,3,3V7H9V5.9169922z M19,19c-0.0014038,1.1040039-0.8959961,1.9985962-2,2H7c-1.1040039-0.0014038-1.9985962-0.8959961-2-2V8h3v2.5C8,10.776123,8.223877,11,8.5,11S9,10.776123,9,10.5V8h6v2.5c0,0.0001831,0,0.0003662,0,0.0005493C15.0001831,10.7765503,15.223999,11.0001831,15.5,11c0.0001831,0,0.0003662,0,0.0006104,0C15.7765503,10.9998169,16.0001831,10.776001,16,10.5V8h3V19z"/></svg>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-sm-12 col-md-6 col-xl-4">
								<div class="card overflow-hidden">
									<div class="card-body">
										<div class="row">
											<div class="col">
												<h3 class="mb-2 fw-semibold">{{ $totalProducts }}</h3>
												<p class="text-muted fs-13 mb-0">Total Products</p>
											</div>
											<div class="col col-auto top-icn dash">
												<div class="counter-icon bg-info dash ms-auto box-shadow-info">
													<svg xmlns="http://www.w3.org/2000/svg" class="fill-white" enable-background="new 0 0 24 24" viewBox="0 0 24 24"><path d="M7.5,12C7.223877,12,7,12.223877,7,12.5v5.0005493C7.0001831,17.7765503,7.223999,18.0001831,7.5,18h0.0006104C7.7765503,17.9998169,8.0001831,17.776001,8,17.5v-5C8,12.223877,7.776123,12,7.5,12z M19,2H5C3.3438721,2.0018311,2.0018311,3.3438721,2,5v14c0.0018311,1.6561279,1.3438721,2.9981689,3,3h14c1.6561279-0.0018311,2.9981689-1.3438721,3-3V5C21.9981689,3.3438721,20.6561279,2.0018311,19,2z M21,19c-0.0014038,1.1040039-0.8959961,1.9985962-2,2H5c-1.1040039-0.0014038-1.9985962-0.8959961-2-2V5c0.0014038-1.1040039,0.8959961-1.9985962,2-2h14c1.1040039,0.0014038,1.9985962,0.8959961,2,2V19z M12,6c-0.276123,0-0.5,0.223877-0.5,0.5v11.0005493C11.5001831,17.7765503,11.723999,18.0001831,12,18h0.0006104c0.2759399-0.0001831,0.4995728-0.223999,0.4993896-0.5v-11C12.5,6.223877,12.276123,6,12,6z M16.5,10c-0.276123,0-0.5,0.223877-0.5,0.5v7.0005493C16.0001831,17.7765503,16.223999,18.0001831,16.5,18h0.0006104C16.7765503,17.9998169,17.0001831,17.776001,17,17.5v-7C17,10.223877,16.776123,10,16.5,10z"/></svg>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- ROW-1 END-->

					<!-- ROW-2 -->
					<div class="row">
						<div class="col-xl-6 col-6 col-md-12">
							<div class="card overflow-hidden">
								<div class="card-header border-bottom">
									<div>
										<h3 class="card-title">Summary of {{ \Carbon\Carbon::now()->format('M, Y')}}</h3>
									</div>
								</div>
								<div class="card-body">
									<div class="tl-container">
									
										<div class="tl-blog secondary">
											<div class="tl-img rounded-circle bg-secondary-transparent">
												<i class="fe fe-message-circle text-secondary text-17"></i>
											</div>
											<div class="tl-details d-flex">
												<p>
													<span class="tl-title-main"> Order </span>  received
												</p>
												<p class="ms-auto text-13">
													<span class="badge bg-secondary text-white">{{ $totalOrderAddedCurrentMonth }}</span>
												</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-6 col-sm-6">
							<div class="card product-sales-main">
								<div class="card-header border-bottom">
									<h3 class="card-title mb-0">Out Of Stock Products</h3>
								</div>
								<div class="card-body">
									
									@if (count($allOutOfStockProducts) > 0)
									<div class="table-responsive">
										<table class="table text-nowrap mb-0 table-bordered">
											<thead class="table-head">
												<tr>
													<th class="bg-transparent border-bottom-0 wp-15">Product Code</th>
													<th class="bg-transparent border-bottom-0">Quantity Left</th>
												</tr>
											</thead>
											<tbody class="table-body">
												@foreach ($allOutOfStockProducts as $outOfStockProduct)
												<tr>
												    
													<td class="text-muted fs-14 fw-semibold"><a href="javascript:void(0)" class="text-dark">{{ $outOfStockProduct->product_code }}</a></td>
													<td class="text-muted fs-13"><a href="javascript:void(0)" class="text-dark">{{ $outOfStockProduct->stock_qty }}</a></td>
													
												</tr>
												@endforeach
												
											</tbody>
										</table>
									</div>
									@else

									<p>No data found</p>

									@endif
								</div>
							</div>
						</div><!-- COL END -->
						
					</div>
					<!-- ROW-2 END -->

						<!-- ROW-4 -->
						<div class="row">
							<div class="col-12 col-sm-12">
								<div class="card product-sales-main">
									<div class="card-header border-bottom">
										<h3 class="card-title mb-0">Recent Order List</h3>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table editable-table table-bordered text-nowrap border-bottom" id="basic-datatable">
												<thead>
													<tr>
														<th class="wd-10p border-bottom-0">S.No</th>
														<th class="wd-10p border-bottom-0">Order Id</th>
														<th class="wd-10p border-bottom-0">Dealer Code</th>
														<th class="wd-10p border-bottom-0">Dealer</th>
														<th class="wd-10p border-bottom-0">Dealer Region/Commuity</th>
                                                        <th class="wd-10p border-bottom-0">Delivery type</th>
														<th class="wd-10p border-bottom-0">Total Amount (AED)</th>
														<th class="wd-10p border-bottom-0">Order Status</th>
														<th class="wd-10p border-bottom-0">Order Remarks</th>
														<th class="wd-10p border-bottom-0">Order Date</th>
													</tr>
												</thead>
												<tbody>
													
													@foreach ($allOrderList as $orderList)
													@php $class='' @endphp
													@if ($orderList->order_status == 'Order Placed')
													@php $class='btn btn-info-gradient' @endphp
													@endif 
													@if ($orderList->order_status == 'accepted')
													@php $class='btn btn-secondary-gradient' @endphp
													@endif 
													@if ($orderList->order_status == 'packed')
													@php $class='btn btn-warning-gradient' @endphp
													@endif 
													@if ($orderList->order_status == 'dispatched')
													@php $class='btn btn-primary-gradient' @endphp
													@endif 

													<tr>
														<td>{{$loop->iteration}}</td>
														<td class="text-14"><a href="{{ route('order.show',$orderList->order_id) }}">{{$orderList->order_id}}</a></td>
														<td>{{$orderList->user_code}}</td>
														<td>{{$orderList->dealer_name}}</td>
														<td>{{$orderList->region}}/{{$orderList->community}}</td>
                                                        <td>{{ ucwords(str_replace('_',' ',$orderList->total_amount)) }}</td>
														<td>{{$orderList->total_amount}}</td>
														<td class="text-center"><button class="{{ $class }} btn-w-lg">{{ ucfirst($orderList->order_status) }}</button></td>
														<td>{{$orderList->order_remarks}}</td>
														<td>{{ \Carbon\Carbon::parse($orderList->order_date)->format('d-m-Y') }}</td>
													</tr>
													@endforeach
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div><!-- COL END -->
						</div>
						<!-- ROW-4 END -->

					</div>
				</div>
			</div>
			<!-- CONTAINER END -->
@endsection