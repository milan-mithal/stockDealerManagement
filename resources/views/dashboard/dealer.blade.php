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
                                                        <td class="text-14"><a href="{{ route('dealerorder.ordershow',$orderList->order_id) }}">{{$orderList->order_id}}</a></td>
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