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
                    <h1 class="page-title">Order Report</h1>
                </div>
                <div class="ms-auto pageheader-btn">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Report</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Order</li>
                    </ol>
                </div>
            </div>
            <!-- PAGE-HEADER END -->


            <!-- Row -->
							<div class="row row-sm">
								<div class="col-lg-12">
                                    
									<div class="card">
                                   
										<div class="card-body">
                                            <div class="col-lg-12">
                                            <form name="frm" action={{ route('report.orderdata') }} method="post">
                                                @csrf
                                                <div class="col-md-6 col-lg-6 col-xl-6 mb-6">
                                                    <div class="example">
                                                        <label for="bootstrapDatePicker_from">From</label>
                                                        <div class="input-group">
                                                            <div id="datePickerStyle1" class="input-group date" data-date-format="mm-dd-yyyy">
                                                                <span class="input-group-addon input-group-text bg-primary-transparent"><i class="fe fe-calendar text-primary-dark"></i></span>
                                                                <input class="form-control" name="from_date" id="bootstrapDatePicker_from" type="text"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-6 col-xl-6 mb-6">
                                                    <div class="example">
                                                        <label for="bootstrapDatePicker_to">To</label>
                                                        <div class="input-group">
                                                            <div id="datePickerStyle1" class="input-group date" data-date-format="mm-dd-yyyy">
                                                                <span class="input-group-addon input-group-text bg-primary-transparent"><i class="fe fe-calendar text-primary-dark"></i></span>
                                                                <input class="form-control" name="to_date" id="bootstrapDatePicker_to" type="text"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- col-4 -->
                                                <button class="btn btn-primary-gradient btn-w-lg" type="submit">Get Details</button>
                                            </form>
                                            </div>
											<div class="table-responsive export-table">
												<table id="file-datatable" class="table table-bordered text-nowrap key-buttons border-bottom  w-100">
													<thead>
														<tr>
															<th class="wd-10p border-bottom-0">S.No</th>
															<th class="wd-10p border-bottom-0">Order Id</th>
                                                            <th class="wd-10p border-bottom-0">Dealer Code</th>
                                                            <th class="wd-10p border-bottom-0">Dealer</th>
															<th class="wd-10p border-bottom-0">Order Status</th>
															<th class="wd-10p border-bottom-0">Order Remarks</th>
                                                            <th class="wd-10p border-bottom-0">Order Date</th>
														</tr>
													</thead>
													<tbody>
                                                        @isset($allOrderDetails)
                                                        @foreach ($allOrderDetails as $allOrderDetail)
														<tr>
                                                            <td>{{$loop->iteration}}</td>
															<td class="text-14">{{$allOrderDetail->order_id}}</td>
                                                            <td>{{$allOrderDetail->user_code}}</td>
                                                            <td>{{$allOrderDetail->dealer_name}}</td>
															<td class="text-center">{{ ucfirst($allOrderDetail->order_status) }}</td>
															<td>{{$allOrderDetail->order_remarks}}</td>
                                                            <td>{{ \Carbon\Carbon::parse($allOrderDetail->order_date)->format('d-m-Y') }}</td>
														</tr>
                                                        @endforeach
                                                        @endisset
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

@section('script')
<script>
    $("#bootstrapDatePicker_from").datepicker({
		autoclose: true,
		format: 'yyyy-mm-dd',
		todayHighlight: true
	}).datepicker('update', new Date());
    $("#bootstrapDatePicker_to").datepicker({
		autoclose: true,
		format: 'yyyy-mm-dd',
		todayHighlight: true
	}).datepicker('update', new Date());
</script>
@endsection