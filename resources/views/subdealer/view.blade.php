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
                        <h1 class="page-title">View/Order Products</h1>
                    </div>
                    <div class="ms-auto pageheader-btn">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Sub Dealer</a></li>
                            <li class="breadcrumb-item active" aria-current="page">View</li>
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
                                                <th class="wd-10p border-bottom-0">Code</th>
                                                <th class="wd-20p border-bottom-0">Order Stock</th>
                                                <th class="wd-10p border-bottom-0">Product Category/Name</th>
                                                <th class="wd-10p border-bottom-0">Image</th>
                                                <th class="wd-10p border-bottom-0">Size</th>
                                                <th class="wd-10p border-bottom-0">Price ({{ $userCurrency }})</th>
                                                <th class="wd-10p border-bottom-0">Total Stock Available</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($allProductList as $productDetails)
                                                @php
                                                    $originalProductPrice = $productDetails->product_price;
                                                    $productPercentagePrice =
                                                        ($originalProductPrice * $dealerPercentage) / 100 +
                                                        $originalProductPrice;
                                                    $rateConversion = $productPercentagePrice;
                                                    if ($userCurrency != 'AED') {
                                                        $rateConversion = $productPercentagePrice * $rate;
                                                    }
                                                    $finalPrice = round($rateConversion, 2);
                                                @endphp
                                                <tr>
                                                    <td>{{ $productDetails->product_code }}</td>
                                                    @if ($productDetails->total_stock_qty > 0)
                                                        <td class="wd-20p"><input type="number" class="wp-50"
                                                                id="order_qty_{{ $productDetails->id }}"
                                                                value="{{ $productDetails->ordered_qty }}"
                                                                placeholder="0" />
                                                            <br />
                                                            <button type="button" class="btn btn-icon mt-3  btn-primary"
                                                                data-bs-placement="top" data-bs-toggle="tooltip"
                                                                data-bs-original-title="Add To Cart"
                                                                id="addToCart_{{ $productDetails->id }}"
                                                                data-qty="{{ $productDetails->total_stock_qty }}"
                                                                data-comingsoon="{{ $productDetails->coming_soon }}"
                                                                data-url="{{ route('subdealerorder.store') }}"
                                                                onClick="addToCart({{ $productDetails->id }})"><i
                                                                    class="fe fe-check"></i></button>
                                                            <button type="button" class="btn btn-icon mt-3  btn-danger"
                                                                data-bs-placement="top" data-bs-toggle="tooltip"
                                                                data-bs-original-title="Remove From Cart"
                                                                id="removeFromCart_{{ $productDetails->id }}"
                                                                data-url="{{ route('subdealerorder.destroy') }}"
                                                                onClick="removeFromCart({{ $productDetails->id }})"><i
                                                                    class="fe fe-x"></i></button>
                                                            <div class="valid-feedback block text-bold mb-2"
                                                                id="successCart_{{ $productDetails->id }}"></div>
                                                            <div class="invalid-feedback block text-bold mb-2"
                                                                id="errorCart_{{ $productDetails->id }}"></div>
                                                        </td>
                                                    @else
                                                        <td>
                                                            <a href="javascript:void(0)" class="btn btn-danger-gradient">Out
                                                                Of Stock</a>
                                                        </td>
                                                    @endif
                                                    <td>{{ $productDetails->catName }}/<br />
                                                        {{ $productDetails->product_name }}</td>
                                                    <td><img class="hpx-100"
                                                            src="{{ url($productDetails->product_image) }}" /></td>
                                                    <td>{{ $productDetails->product_size }}</td>
                                                    <td>{{ $finalPrice }}</td>
                                                    <td>
                                                        @if ($productDetails->coming_soon == '1' && $productDetails->total_stock_qty - $productDetails->stock_coming_soon > 0)
                                                            <h3 class="tag tag-blue">In Stock:&nbsp;
                                                                <strong>{{ $productDetails->total_stock_qty - $productDetails->stock_coming_soon }}</strong>
                                                            </h3>
                                                            <br />
                                                            <h5 class="tag tag-orange">Coming Soon:&nbsp;
                                                                <strong>{{ $productDetails->stock_coming_soon }}</strong>
                                                            </h5>
                                                        @elseif ($productDetails->coming_soon == '1' && $productDetails->total_stock_qty - $productDetails->stock_coming_soon <= 0)
                                                            <h3 class="tag tag-blue">In Stock:&nbsp; <strong>0</strong></h3>
                                                            <br />
                                                            <h5 class="tag tag-danger">Available For Order:&nbsp;
                                                                <strong>{{ $productDetails->total_stock_qty }}</strong>
                                                            </h5>
                                                            <br />
                                                            <h5 class="tag tag-orange">Coming Soon:&nbsp;
                                                                <strong>{{ $productDetails->stock_coming_soon }}</strong>
                                                            </h5>
                                                        @else
                                                            <h3 class="tag tag-blue">In Stock:&nbsp;
                                                                <strong>{{ $productDetails->total_stock_qty }}</strong>
                                                            </h3>
                                                        @endif
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
