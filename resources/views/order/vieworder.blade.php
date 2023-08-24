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
                            <div class="clearfix">
                                <div class="float-start">
                                    <h3 class="card-title mb-0">#{{ $orderDetails->order_id }}</h3>
                                </div>
                                <div class="float-end">
                                    <h3 class="card-title">Date: {{ \Carbon\Carbon::parse($orderDetails->order_date)->format('d-m-Y') }}</h3>
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
                                        {{ $orderDetails->region }} / {{ $orderDetails->community }}<br/>
                                        {{ $orderDetails->phone_no }}
                                    </address>
                                </div>

                                {{-- <div class="col-lg-6 text-end">
                                    <p class="h3">Invoice To:</p>
                                    <address>
                                        Street Address<br>
                                        State, City<br>
                                        Country, Postal Code<br>
                                        invoice@spruko.com
                                    </address>
                                </div> --}}
                            </div>
                            <div class="table-responsive push">
                                <table class="table table-bordered table-hover mb-0 text-nowrap border-bottom">
                                    <tbody><tr class=" ">
                                        <th class="text-center"></th>
                                        <th>Product</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-end">Product Price (AED)</th>
                                        <th class="text-end">Sub Total (AED)</th>
                                    </tr>
                                    @php $total = 0; @endphp
                                    @foreach ($allorderProductList as $orderProductList)
                                    <tr>
                                        <td class="text-center">{{$loop->iteration}}</td>
                                        <td>
                                            <p class="font-w600 mb-1">{{ $orderProductList->product_code}}</p>
                                            <div class="text-muted"><div class="text-muted">Category: {{ $orderProductList->product_category}}, Product Name: {{ $orderProductList->product_name}}, Size: {{ $orderProductList->product_size}}</div></div>
                                        </td>
                                        <td class="text-center">{{ $orderProductList->order_quantity}}</td>
                                        <td class="text-end">{{ $orderProductList->product_price}}</td>
                                        <td class="text-end">{{ $orderProductList->order_quantity * $orderProductList->product_price}}</td>
                                    </tr>
                                    @php $total += $orderProductList->order_quantity * $orderProductList->product_price; @endphp
                                    @endforeach
                                    <tr>
                                        <td colspan="4" class="fw-bold text-uppercase text-end">Total</td>
                                        <td class="fw-bold text-end h4">{{ $total }}</td>
                                    </tr>
                                </tbody></table>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a class="btn btn-primary-gradient" data-bs-target="#modalInput" data-bs-toggle="modal" href="javascript:void(0)">Order Status</a>
                            <button type="button" class="btn btn-info-gradient" onclick="javascript:window.print();"><i class="si si-printer"></i> Print Order Details</button>
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
                <form method="post" name="frm" id="frm" action="{{ route('order.update', $orderDetails->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="form-label text-muted">Order Status</label>
                        <div class="input-group">
                            <select class="form-control" name="order_status" id="order_status">
                                <option value=""> Order Status</option>
                                @foreach(App\Enums\OrderStatusEnums::values() as $key=>$value)
                                    <option value="{{ $key }}" @selected(old('order_status',$orderDetails->order_status) == $key)>{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('order_status')
                            <div class="invalid-feedback block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label text-muted">Order Remarks:</label>
                        <textarea cols="30" rows="5" class="form-control" name="order_remarks" id="order_remarks">{{ old('order_remarks',$orderDetails->order_remarks) }}</textarea>
                        @error('order_remarks')
                        <div class="invalid-feedback block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit" id="submit" class="btn btn-primary-gradient">Update Status</button>
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
    });
</script>
@endif
@endsection
