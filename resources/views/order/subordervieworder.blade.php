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
                                            {{ $orderDetails->user_code }}<br>
                                            {{ $orderDetails->user_name }}<br>
                                            {{ $orderDetails->dealer_name }}<br>
                                            {{ $orderDetails->address }}<br>
                                            {{ $orderDetails->region }} / {{ $orderDetails->community }}<br />
                                            {{ $orderDetails->phone_no }}
                                        </address>
                                    </div>
                                    <div class="col-lg-6 text-end">
                                        <p class="h3">Delivery Type:</p>
                                        <address>
                                            {{ ucwords($orderDetails->order_status) }}<br>
                                        </address>
                                    </div>
                                </div>
                                <div class="table-responsive push">
                                    <table class="table table-bordered table-hover mb-0 text-nowrap border-bottom">
                                        <tbody>
                                            <tr class=" ">
                                                <th class="text-center"></th>
                                                <th>Product</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-end">Price(AED)</th>
                                                <th class="text-end">Boxes</th>
                                                {{-- <th class="text-end">Weight (KGS)</th> --}}
                                                <th class="text-end">Weight(KGS)</th>
                                                <th class="text-end">CBM</th>
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
                                                            {{ $orderProductList->cat_name ?? $orderProductList->product_category }},
                                                            <br />Name: {{ $orderProductList->product_name }},Size:
                                                            {{ $orderProductList->product_size }}
                                                        </div>
                                                    </td>
                                                    <td class="text-center">{{ $orderProductList->order_quantity }}</td>
                                                    <td class="text-end">{{ $orderProductList->product_price }}</td>
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
                                {{-- @if ($orderDetails->order_status != 'dispatched' && $orderDetails->order_status != 'cancelled') --}}
                                {{-- @endif --}}
                                <button type="button" class="btn btn-info-gradient" onclick="javascript:window.print();"><i
                                        class="si si-printer"></i> Print Order Details</button>
                            </div>
                        </div>
                    </div><!-- COL-END -->
                    <div class="d-flex flex-row justify-content-between mt-10 mb-2 p-3 br-5">
                        <div class="p-sm-4 p-2 bg-gray-200">
                            RECEIVED BY
                        </div>
                        <div class="p-sm-4 p-2 bg-gray-300">
                            CHECKED BY
                        </div>
                        <div class="p-sm-4 p-2 bg-gray-400">
                            PREPARED BY
                        </div>
                    </div>
                </div>
                <!-- ROW-1 CLOSED -->
            </div>
        </div>
    </div>
    <!-- CONTAINER CLOSED -->
@endsection
@section('script')
@endsection
