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
                        <h1 class="page-title">Order-Details</h1>
                    </div>
                    <div class="ms-auto pageheader-btn">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">Orders</li>
                            <li class="breadcrumb-item"><a href="javascript:void(0);">All Order List</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Order Details</li>
                        </ol>
                    </div>
                </div>
                <!-- PAGE-HEADER END -->
                <!-- ROW-1 OPEN -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            @if (Session::has('success'))
                                <div class="card-header border-bottom">
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ Session::get('success') }}
                                        @php
                                            Session::forget('success');
                                        @endphp
                                    </div>
                                </div>
                            @endif
                            @if (Session::has('error'))
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
                                <div class="clearfix">
                                    <div class="float-start">
                                        <h3 class="card-title mb-0">#{{ $orderDetails->order_id }}</h3>
                                    </div>
                                    <div class="float-end">
                                        <h3 class="card-title">Date:
                                            {{ \Carbon\Carbon::parse($orderDetails->order_date)->format('d-m-Y') }}</h3>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-6 ">
                                        <p class="h3">Order Form:</p>
                                        <address>
                                            {{ $orderDetails->user_name }}<br>
                                            {{ $orderDetails->dealer_name }}<br>
                                            {{ $orderDetails->address }}<br>
                                            {{ $orderDetails->region }} / {{ $orderDetails->community }}<br />
                                            {{ $orderDetails->phone_no }}
                                        </address>
                                    </div>
                                    {{-- <div class="col-lg-6 text-end">
                                    <p class="h3">Pickup by:</p>
                                    <address>
                                        {{ ucwords(str_replace("_", " ", $orderDetails->delivery_type)); }}<br>
                                        {{ $orderDetails->third_party_details }}<br>
                                        {{ $orderDetails->courier_company }}<br>
                                        {{ $orderDetails->awb_number }}<br>
                                    </address>
                                </div> --}}
                                </div>
                                <div class="table-responsive push">
                                    <table class="table table-bordered table-hover mb-0 text-nowrap border-bottom">
                                        <tbody>
                                            <tr class=" ">
                                                <th class="text-center"></th>
                                                <th>Product</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-end">Price ({{ $orderDetails->currency }})</th>
                                                {{-- <th class="text-end">Sub Total (AED)</th> --}}
                                                <th class="text-end">Boxes</th>
                                                {{-- <th class="text-end">Weight (KGS)</th> --}}
                                                <th class="text-end">Sub Weight (KGS)</th>
                                                <th class="text-end">Box Dimension (CBM)</th>
                                            </tr>
                                            @php
                                                $total = 0;
                                                $totalqty = 0;
                                                $totalBoxes = 0;
                                                $totalWeight = 0;
                                                $totalCBM = 0;
                                            @endphp
                                            @foreach ($allorderProductList as $orderProductList)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>
                                                        <p class="font-w600 mb-1">{{ $orderProductList->product_code }}</p>
                                                        <div class="text-muted">Category:
                                                            {{ $orderProductList->cat_name ?? $orderProductList->product_category }},<br />
                                                            Product Name:
                                                            {{ $orderProductList->product_name }}, <br />Size:
                                                            {{ $orderProductList->product_size }}</div>
                                                    </td>
                                                    <td class="text-center">{{ $orderProductList->order_quantity }}</td>
                                                    <td class="text-end">{{ $orderProductList->product_price }}</td>
                                                    {{-- <td class="text-end">{{ $orderProductList->order_quantity * $orderProductList->product_price}}</td> --}}
                                                    <td class="text-end">{{ $orderProductList->total_boxes }}</td>
                                                    {{-- <td class="text-end">{{ $orderProductList->weight_per_box}}</td> --}}
                                                    <td class="text-end">
                                                        {{ $orderProductList->total_boxes * $orderProductList->weight_per_box }}
                                                    </td>
                                                    <td class="text-end">{{ $orderProductList->box_dimension }} CMS</td>
                                                </tr>
                                                @php $totalqty += $orderProductList->order_quantity; @endphp
                                                @php $total += $orderProductList->order_quantity * $orderProductList->product_price; @endphp
                                                @php $totalBoxes += $orderProductList->total_boxes; @endphp
                                                @php $totalWeight += $orderProductList->total_boxes*$orderProductList->weight_per_box; @endphp
                                                @php $totalCBM += $orderProductList->cbm; @endphp
                                            @endforeach
                                            <tr>
                                                <td colspan="2" class="fw-bold text-uppercase text-end">Total</td>
                                                <td class="fw-bold text-end h4">{{ $totalqty }}</td>
                                                <td class="fw-bold text-end h4">&nbsp;</td>
                                                {{-- <td class="fw-bold text-end h4">{{ $total }}</td> --}}
                                                <td class="fw-bold text-end h4">{{ $totalBoxes }}</td>
                                                {{-- <td class="fw-bold text-end h4">&nbsp;</td> --}}
                                                <td class="fw-bold text-end h4">{{ $totalWeight }}</td>
                                                <td class="fw-bold text-end h4">{{ $totalCBM }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                @if ($orderDetails->order_status != 'accepted')
                                    <button type="button" class="btn btn-primary-gradient"
                                        onclick="javascript:location.href='{{ route('dealerorder.subdealerorderacceptedstatus', $orderDetails->id) }}'"><i
                                            class="fe fe-check"></i> Accept Order</button>
                                @endif
                                @if ($orderDetails->order_status != 'cancelled')
                                    <button type="button" class="btn btn-danger-gradient"
                                        onclick="javascript:location.href='{{ route('dealerorder.subdealerordercancelstatus', $orderDetails->id) }}'"><i
                                            class="fe fe-x"></i> Cancel Order</button>
                                @endif
                                @if ($orderDetails->order_placed == 'No')
                                    <button type="button" class="btn btn-success-gradient"
                                        onclick="javascript:location.href='{{ route('dealerorder.subdealerplaceorder', $orderDetails->order_id) }}'"><i
                                            class="fe fe-upload"></i> Place Order</button>
                                @endif
                                <button type="button" class="btn btn-info-gradient" onclick="javascript:window.print();"><i
                                        class="si si-printer"></i> Print Order Details</button>
                            </div>
                        </div>
                    </div><!-- COL-END -->
                </div>
                <!-- ROW-1 CLOSED -->
            </div>
        </div>
    </div>
    <!-- CONTAINER CLOSED -->
    <!-- INPUT MODAL -->
    <div class="modal fade" id="modalInput">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form method="post" name="frm" id="frm"
                        action="{{ route('order.update', $orderDetails->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="form-label text-muted">Order Status</label>
                            <div class="input-group">
                                <select class="form-control" name="order_status" id="order_status">
                                    <option value=""> Order Status</option>
                                    @foreach (App\Enums\OrderStatusEnums::values() as $key => $value)
                                        <option value="{{ $key }}" @selected(old('order_status', $orderDetails->order_status) == $key)>
                                            {{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('order_status')
                                    <div class="invalid-feedback block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label text-muted">Order Remarks:</label>
                            <textarea cols="30" rows="5" class="form-control" name="order_remarks" id="order_remarks">{{ old('order_remarks', $orderDetails->order_remarks) }}</textarea>
                            @error('order_remarks')
                                <div class="invalid-feedback block">{{ $message }}</div>
                            @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit" id="submit" class="btn btn-primary-gradient">Update
                        Status</button>
                    <a href="javascript:void(0);" class="btn btn-light" data-bs-dismiss="modal">Close</a>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @if ($errors->any())
        <script>
            $(window).on('load', function() {
                $("#modalInput").modal('show');
            });
        </script>
    @endif
@endsection
