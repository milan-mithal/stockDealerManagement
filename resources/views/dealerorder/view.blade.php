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
                                                    <button id="button" class="btn btn-primary-gradient mb-4 data-table-btn" data-bs-target="#modalInput" data-bs-toggle="modal" href="javascript:void(0)">Provide Pickup Details</button>
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

<!-- INPUT MODAL -->
<div class="modal fade" id="modalInput">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form method="post" name="frm" id="frm" action="{{ route('dealerorder.create') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="form-label text-muted">Pickup By</label>
                        <div class="input-group">
                            <select class="form-control order_status" name="delivery_by" id="delivery_by">
                                <option value=""> Pickup By</option>
                                @foreach(App\Enums\DeliveryTypeEnums::values() as $key=>$value)
                                    <option value="{{ $key }}" @selected(old('delivery_by') == $key)>{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('delivery_by')
                            <div class="invalid-feedback block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group d-none" id="delivery_data">
                            <label class="form-label text-muted">Third Party Details:</label>
                            <textarea type="text" class="form-control" name="third_party_details" id="third_party_details">{{ old('third_party_details') }}</textarea>
                            @error('third_party_details')
                            <div class="invalid-feedback block">{{ $message }}</div>
                            @enderror
                    </div>

                    <div class="form-group d-none" id="delivery_data_2">
                        <label class="form-label text-muted">Delivery Details:</label>
                        <textarea type="text" class="form-control" name="delivery_details" id="delivery_details">{{ old('delivery_details') }}</textarea>
                        @error('delivery_details')
                        <div class="invalid-feedback block">{{ $message }}</div>
                        @enderror
                </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit" id="submit" class="btn btn-primary-gradient">Place Order</button>
                    <a href="javascript:void(0);" class="btn btn-light" data-bs-dismiss="modal">Close</a>
                </div>
        </form>
        </div>
    </div>
</div>

@endsection

@section('script')
@if($errors->any())
<script>
    $(window).on('load', function() {
        $("#modalInput").modal('show');
        const pickupby = $('#delivery_by').val();
        if (pickupby == 'third_party') {
            $('#delivery_data').removeClass('d-none');
        }
    });
</script>
@endif

<script>
    $('.order_status').change(function () {
        const order_status = this.value;
        if (order_status == 'third_party') {
            $('#delivery_data').removeClass('d-none');
        } else {
            $('#delivery_data').addClass('d-none');
        }
        if (order_status == 'delivery') {
            $('#delivery_data_2').removeClass('d-none');
        } else {
            $('#delivery_data_2').addClass('d-none');
        }
    });
</script>




@endsection