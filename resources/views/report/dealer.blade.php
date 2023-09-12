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
                    <h1 class="page-title">Dealer Report</h1>
                </div>
                <div class="ms-auto pageheader-btn">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Report</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dealer</li>
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
											<div class="table-responsive export-table">
												<table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom  w-100">
													<thead>
														<tr>
															<th class="wd-15p border-bottom-0">Dealer Name</th>
															<th class="wd-15p border-bottom-0">Number of Orders</th>
                                                            <th class="wd-25p border-bottom-0">Maximum Order Amount (AED)</th>
														</tr>
													</thead>
													<tbody>
                                                        @foreach ($allDealerswithOrderCounts as $allDealerswithOrderCount)
														<tr>
															<td>{{$allDealerswithOrderCount->dealer_name}}</td>
                                                            <td>{{$allDealerswithOrderCount->order_count}}</td>
															<td>{{$allDealerswithOrderCount->total_amount}}</td>
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