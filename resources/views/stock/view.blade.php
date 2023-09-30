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
                    <h1 class="page-title">Manage Stocks</h1>
                </div>
                <div class="ms-auto pageheader-btn">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Stock</a></li>
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
															<th class="wd-15p border-bottom-0">Category</th>
                                                            <th class="wd-15p border-bottom-0">Coming Soon</th>
                                                            <th class="wd-25p border-bottom-0">Total Stock Available</th>
                                                            <th class="wd-25p border-bottom-0">Total Stock Sold Till Today</th>
                                                            <th class="wd-25p border-bottom-0">Minimum Quanity Alert</th>
                                                            <th class="wd-25p border-bottom-0">Action</th>
														</tr>
													</thead>
													<tbody>
                                                        @foreach ($allStockList as $stockList)
														<tr>
															<td>{{$stockList->product_code}}</td>
                                                            <td>{{$stockList->product_category}}</td>
                                                            <td>{{$stockList->stock_coming_soon}}
                                                            </td>
															<td>{{$stockList->stock_qty}}</td>
															<td>{{$stockList->stock_sold_qty}}</td>
															<td>{{$stockList->stock_min_qty}}</td>
                                                            <td>
                                                                @if ($stockList->status == 'active')
                                                                <a href="javascript:void(0)" class="btn btn-primary-gradient">Product is Active</a>
                                                                @endif
                                                                @if ($stockList->status == 'inactive')
                                                                <a href="javascript:void(0)" class="btn btn-danger-gradient">Product is Blocked</a>
                                                                @endif
                                                                <a href="{{ route('stock.edit', $stockList->id) }}"><button type="button" class="btn btn-icon  btn-primary"><i class="fe fe-edit"></i></button></a>
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