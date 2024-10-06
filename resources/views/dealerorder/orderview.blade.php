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
                        <h1 class="page-title">Your Order's List</h1>
                    </div>
                    <div class="ms-auto pageheader-btn">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Dealer</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Order List</li>
                        </ol>
                    </div>
                </div>
                <!-- PAGE-HEADER END -->
                <!-- Row -->
                <div class="row row-sm">
                    <div class="col-lg-12">
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
                                <div class="table-responsive">
                                    <table class="table editable-table table-bordered text-nowrap border-bottom"
                                        id="basic-datatable">
                                        <thead>
                                            <tr>
                                                <th class="wd-10p border-bottom-0">S.No</th>
                                                <th class="wd-10p border-bottom-0">Order Id</th>
                                                <th class="wd-10p border-bottom-0">Total Amount
                                                    ({{ Auth::user()->currency }})</th>
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
                                                @if ($orderList->order_status == 'cancelled')
                                                    @php $class='btn btn-danger-gradient' @endphp
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
                    </div>
                </div>
                <!-- End Row -->
            </div>
        </div>
    </div>
    <!-- CONTAINER CLOSED -->
@endsection
