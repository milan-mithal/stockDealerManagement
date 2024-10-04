@extends('common.layout')
@section('content')
    <!--app-content open-->
    <div class="app-content main-content mt-0">
        <div class="side-app">
            <!-- CONTAINER -->
            <div class="main-container container-fluid">
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
                    <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
                        <div class="card overflow-hidden">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <p class="text-muted fs-13 mb-0">Total Products</p>
                                        <h4 class="mb-2 fw-semibold">{{ $totalProductsNatural + $totalProductsEssentials }}
                                        </h4>
                                        <p class="text-muted fs-13 mb-0">Natural :
                                            <span class="icn-box text-success fw-semibold fs-13 me-1">
                                                {{ $totalProductsNatural }}</span>
                                        </p>
                                        <p class="text-muted fs-13 mb-0">Essentials :
                                            <span
                                                class="icn-box text-success fw-semibold fs-13 me-1">{{ $totalProductsEssentials }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="col col-auto top-icn dash">
                                        <div class="counter-icon bg-info dash ms-auto box-shadow-info">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="fill-white"
                                                enable-background="new 0 0 24 24" viewBox="0 0 24 24">
                                                <path
                                                    d="M7.5,12C7.223877,12,7,12.223877,7,12.5v5.0005493C7.0001831,17.7765503,7.223999,18.0001831,7.5,18h0.0006104C7.7765503,17.9998169,8.0001831,17.776001,8,17.5v-5C8,12.223877,7.776123,12,7.5,12z M19,2H5C3.3438721,2.0018311,2.0018311,3.3438721,2,5v14c0.0018311,1.6561279,1.3438721,2.9981689,3,3h14c1.6561279-0.0018311,2.9981689-1.3438721,3-3V5C21.9981689,3.3438721,20.6561279,2.0018311,19,2z M21,19c-0.0014038,1.1040039-0.8959961,1.9985962-2,2H5c-1.1040039-0.0014038-1.9985962-0.8959961-2-2V5c0.0014038-1.1040039,0.8959961-1.9985962,2-2h14c1.1040039,0.0014038,1.9985962,0.8959961,2,2V19z M12,6c-0.276123,0-0.5,0.223877-0.5,0.5v11.0005493C11.5001831,17.7765503,11.723999,18.0001831,12,18h0.0006104c0.2759399-0.0001831,0.4995728-0.223999,0.4993896-0.5v-11C12.5,6.223877,12.276123,6,12,6z M16.5,10c-0.276123,0-0.5,0.223877-0.5,0.5v7.0005493C16.0001831,17.7765503,16.223999,18.0001831,16.5,18h0.0006104C16.7765503,17.9998169,17.0001831,17.776001,17,17.5v-7C17,10.223877,16.776123,10,16.5,10z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
                        <div class="card overflow-hidden">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <p class="text-muted fs-13 mb-0">Total Stock Amount</p>
                                        <h4 class="mb-2 fw-semibold">AED
                                            {{ $totalStockAmountNatural->total_stock_price + $totalStockAmountEssentials->total_stock_price }}
                                        </h4>
                                        <p class="text-muted fs-13 mb-0">Natural :
                                            <span class="icn-box text-success fw-semibold fs-13 me-1">AED
                                                {{ $totalStockAmountNatural->total_stock_price }}
                                            </span>
                                        </p>
                                        <p class="text-muted fs-13 mb-5">Essentials :
                                            <span class="icn-box text-success fw-semibold fs-13 me-1">
                                                AED {{ $totalStockAmountEssentials->total_stock_price }}</span>
                                        </p>
                                        <p class="text-muted fs-13 mb-0">Total Stocks</p>
                                        <h4 class="mb-2 fw-semibold">
                                            {{ $totalStockAmountNatural->total_stock_qty + $totalStockAmountEssentials->total_stock_qty }}
                                        </h4>
                                        <p class="text-muted fs-13 mb-0">Natural :
                                            <span class="icn-box text-success fw-semibold fs-13 me-1">
                                                {{ $totalStockAmountNatural->total_stock_qty }}</span>
                                        </p>
                                        <p class="text-muted fs-13 mb-0">Essentials :
                                            <span
                                                class="icn-box text-success fw-semibold fs-13 me-1">{{ $totalStockAmountEssentials->total_stock_qty }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="col col-auto top-icn dash">
                                        <div class="counter-icon bg-warning dash ms-auto box-shadow-warning">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="fill-white"
                                                enable-background="new 0 0 24 24" viewBox="0 0 24 24">
                                                <path
                                                    d="M9,10h2.5c0.276123,0,0.5-0.223877,0.5-0.5S11.776123,9,11.5,9H10V8c0-0.276123-0.223877-0.5-0.5-0.5S9,7.723877,9,8v1c-1.1045532,0-2,0.8954468-2,2s0.8954468,2,2,2h1c0.5523071,0,1,0.4476929,1,1s-0.4476929,1-1,1H7.5C7.223877,15,7,15.223877,7,15.5S7.223877,16,7.5,16H9v1.0005493C9.0001831,17.2765503,9.223999,17.5001831,9.5,17.5h0.0006104C9.7765503,17.4998169,10.0001831,17.276001,10,17v-1c1.1045532,0,2-0.8954468,2-2s-0.8954468-2-2-2H9c-0.5523071,0-1-0.4476929-1-1S8.4476929,10,9,10z M21.5,12H17V2.5c0.000061-0.0875244-0.0228882-0.1735229-0.0665283-0.2493896c-0.1375732-0.2393188-0.4431152-0.3217773-0.6824951-0.1842041l-3.2460327,1.8603516L9.7481079,2.0654297c-0.1536865-0.0878906-0.3424072-0.0878906-0.4960938,0l-3.256897,1.8613281L2.7490234,2.0664062C2.6731567,2.0227661,2.5871582,1.9998779,2.4996338,1.9998779C2.2235718,2.000061,1.9998779,2.223938,2,2.5v17c0.0012817,1.380188,1.119812,2.4987183,2.5,2.5H19c1.6561279-0.0018311,2.9981689-1.3438721,3-3v-6.5006104C21.9998169,12.2234497,21.776001,11.9998169,21.5,12z M4.5,21c-0.828064-0.0009155-1.4990845-0.671936-1.5-1.5V3.3623047l2.7412109,1.5712891c0.1575928,0.0872192,0.348877,0.0875854,0.5068359,0.0009766L9.5,3.0761719l3.2519531,1.8583984c0.157959,0.0866089,0.3492432,0.0862427,0.5068359-0.0009766L16,3.3623047V19c0.0008545,0.7719116,0.3010864,1.4684448,0.7803345,2H4.5z M21,19c0,1.1045532-0.8954468,2-2,2s-2-0.8954468-2-2v-6h4V19z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ROW-1 END-->
                <!-- ROW-4 -->
                <div class="row">
                    <div class="col-12 col-sm-12">
                        <div class="card product-sales-main">
                            <div class="card-header border-bottom">
                                <h3 class="card-title mb-0">Recent Sub Dealer Order List</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table editable-table table-bordered text-nowrap border-bottom"
                                        id="basic-datatable">
                                        <thead>
                                            <tr>
                                                <th class="wd-10p border-bottom-0">S.No</th>
                                                <th class="wd-10p border-bottom-0">Order Id</th>
                                                <th class="wd-10p border-bottom-0">Total Amount</th>
                                                <th class="wd-10p border-bottom-0">Order Status</th>
                                                <th class="wd-10p border-bottom-0">Order Remarks</th>
                                                <th class="wd-10p border-bottom-0">Order Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($allSubOrderList as $orderList)
                                                @php $class='' @endphp
                                                @if ($orderList->order_status == 'Order Placed')
                                                    @php $class='btn btn-info-gradient' @endphp
                                                @endif
                                                @if ($orderList->order_status == 'accepted')
                                                    @php $class='btn btn-secondary-gradient' @endphp
                                                @endif
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td class="text-14"><a
                                                            href="{{ route('dealerorder.subdealerordershow', $orderList->order_id) }}">{{ $orderList->order_id }}</a>
                                                    </td>
                                                    <td>{{ $orderList->currency }} {{ $orderList->total_amount }}</td>
                                                    <td class="text-center"><button
                                                            class="{{ $class }} btn-w-lg">{{ ucfirst($orderList->order_status) }}</button>
                                                    </td>
                                                    <td>{{ $orderList->order_remarks }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($orderList->order_date)->format('d-m-Y') }}
                                                    </td>
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
                <!-- ROW-4 -->
                <div class="row">
                    <div class="col-12 col-sm-12">
                        <div class="card product-sales-main">
                            <div class="card-header border-bottom">
                                <h3 class="card-title mb-0">Recent Order List</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table editable-table table-bordered text-nowrap border-bottom"
                                        id="basic-datatable">
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
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td class="text-14"><a
                                                            href="{{ route('dealerorder.ordershow', $orderList->order_id) }}">{{ $orderList->order_id }}</a>
                                                    </td>
                                                    <td>{{ $orderList->total_amount }}</td>
                                                    <td class="text-center"><button
                                                            class="{{ $class }} btn-w-lg">{{ ucfirst($orderList->order_status) }}</button>
                                                    </td>
                                                    <td>{{ $orderList->order_remarks }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($orderList->order_date)->format('d-m-Y') }}
                                                    </td>
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
