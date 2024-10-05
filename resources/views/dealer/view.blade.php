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
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Dealer</a></li>
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
                                    <div>
                                        <p><strong>To add all products in cart, enter Quanity & Click on Add All Product
                                                Button.
                                                This will delete all previous added product(s) from cart.</strong></p>
                                        <form name="allproduct" action="{{ route('dealer.create') }}" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <label for="formFile" class="form-label">Enter Quantity</label>
                                                <input class="form-control" type="number" id="quantity" name="quantity"
                                                    min="1" max="10" maxlength="2" value="1">
                                                <button type="submit" name="submit" id="submit"
                                                    class="btn ripple btn-primary mt-4">Add All Products</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="panel panel-primary">
                                        <div class="tab-menu-heading border-bottom-0">
                                            <div class="tabs-menu4 border-bottomo-sm">
                                                <!-- Tabs -->
                                                <nav class="nav d-sm-flex d-block">
                                                    <a class="nav-link border border-bottom-0 br-sm-5 me-2 active"
                                                        data-bs-toggle="tab" href="#tab25">
                                                        <img src="{{ url('/images/shamsnaturals-logo.png') }}"
                                                            class="hpx-60" alt="Natural Image">
                                                    </a>
                                                    <a class="nav-link border border-bottom-0 br-sm-5 me-2"
                                                        data-bs-toggle="tab" href="#tab26">
                                                        <img src="{{ url('/images/essentials.jpeg') }}" class="hpx-60"
                                                            alt="Essentials Image">
                                                    </a>
                                                </nav>
                                            </div>
                                        </div>
                                        <div class="panel-body tabs-menu-body">
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tab25">
                                                    <table
                                                        class="table editable-table table-bordered text-nowrap border-bottom"
                                                        id="basic-datatable">
                                                        <thead>
                                                            <tr>
                                                                <th class="wd-sm-10p border-bottom-0">Code</th>
                                                                <th class="wd-sm-10p border-bottom-0">Order Stock</th>
                                                                {{-- <th class="wd-sm-10p border-bottom-0">Category/Name
                                                                </th> --}}
                                                                <th class="wd-md-50p border-bottom-0">Image</th>
                                                                <th class="wd-sm-10p border-bottom-0">Price (AED)</th>
                                                                <th class="wd-sm-10p border-bottom-0">Total Stock Available
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($productListNatural as $productDetails)
                                                                <tr>
                                                                    <td class="wd-sm-10p">
                                                                        {{ $productDetails->product_code }}</td>
                                                                    @if ($productDetails->total_stock_qty > 0)
                                                                        <td class="wd-sm-10p"><input type="number"
                                                                                class="wp-50"
                                                                                id="order_qty_{{ $productDetails->id }}"
                                                                                value="{{ $productDetails->ordered_qty }}"
                                                                                placeholder="0" />
                                                                            <br />
                                                                            <button type="button"
                                                                                class="btn btn-icon mt-3  btn-primary"
                                                                                data-bs-placement="top"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-original-title="Add To Cart"
                                                                                id="addToCart_{{ $productDetails->id }}"
                                                                                data-qty="{{ $productDetails->total_stock_qty }}"
                                                                                data-comingsoon="{{ $productDetails->coming_soon }}"
                                                                                data-url="{{ route('dealerorder.store') }}"
                                                                                onClick="addToCart({{ $productDetails->id }})"><i
                                                                                    class="fe fe-check"></i></button>
                                                                            <button type="button"
                                                                                class="btn btn-icon mt-3  btn-danger"
                                                                                data-bs-placement="top"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-original-title="Remove From Cart"
                                                                                id="removeFromCart_{{ $productDetails->id }}"
                                                                                data-url="{{ route('dealerorder.destroy') }}"
                                                                                onClick="removeFromCart({{ $productDetails->id }})"><i
                                                                                    class="fe fe-x"></i></button>
                                                                            <div class="valid-feedback block text-bold mb-2"
                                                                                id="successCart_{{ $productDetails->id }}">
                                                                            </div>
                                                                            <div class="invalid-feedback block text-bold mb-2"
                                                                                id="errorCart_{{ $productDetails->id }}">
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td class="wd-sm-10p">
                                                                            <a href="javascript:void(0)"
                                                                                class="btn btn-danger-gradient">Out Of
                                                                                Stock</a>
                                                                        </td>
                                                                    @endif
                                                                    {{-- <td class="wd-sm-10p">
                                                                        {{ $productDetails->catName }}/<br />
                                                                        {{ $productDetails->product_name }}</td> --}}
                                                                    <td class="wd-md-50p"><img class="wpx-250 hpx-200"
                                                                            src="{{ url($productDetails->product_image) }}" />
                                                                    </td>
                                                                    <td class="wd-sm-10p text-center">
                                                                        {{ $productDetails->product_price }}</td>
                                                                    <td class="wd-sm-10p">
                                                                        @if ($productDetails->coming_soon == '1' && $productDetails->total_stock_qty - $productDetails->stock_coming_soon > 0)
                                                                            <h3 class="tag tag-blue">In Stock:&nbsp;
                                                                                <strong>{{ $productDetails->total_stock_qty - $productDetails->stock_coming_soon }}</strong>
                                                                            </h3>
                                                                            <br />
                                                                            <h5 class="tag tag-orange">Coming Soon:&nbsp;
                                                                                <strong>{{ $productDetails->stock_coming_soon }}</strong>
                                                                            </h5>
                                                                        @elseif ($productDetails->coming_soon == '1' && $productDetails->total_stock_qty - $productDetails->stock_coming_soon <= 0)
                                                                            <h3 class="tag tag-blue">In Stock:&nbsp;
                                                                                <strong>0</strong>
                                                                            </h3>
                                                                            <br />
                                                                            <h5 class="tag tag-danger">Available For
                                                                                Order:&nbsp;
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
                                                <div class="tab-pane" id="tab26">
                                                    <table
                                                        class="table editable-table table-bordered text-nowrap border-bottom"
                                                        id="example3">
                                                        <thead>
                                                            <tr>
                                                                <th class="wd-sm-10p border-bottom-0">Code</th>
                                                                <th class="wd-sm-10p border-bottom-0">Order Stock</th>
                                                                {{-- <th class="wd-sm-10p border-bottom-0">Category/Name
                                                                </th> --}}
                                                                <th class="wd-md-50p border-bottom-0">Image</th>
                                                                <th class="wd-sm-10p border-bottom-0">Price (AED)</th>
                                                                <th class="wd-sm-10p border-bottom-0">Total Stock Available
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($productListEssentials as $productDetailsEssential)
                                                                <tr>
                                                                    <td class="wd-sm-10p">
                                                                        {{ $productDetailsEssential->product_code }}</td>
                                                                    @if ($productDetailsEssential->total_stock_qty > 0)
                                                                        <td class="wd-sm-10p"><input type="number"
                                                                                class="wp-50"
                                                                                id="order_qty_{{ $productDetailsEssential->id }}"
                                                                                value="{{ $productDetailsEssential->ordered_qty }}"
                                                                                placeholder="0" />
                                                                            <br />
                                                                            <button type="button"
                                                                                class="btn btn-icon mt-3  btn-primary"
                                                                                data-bs-placement="top"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-original-title="Add To Cart"
                                                                                id="addToCart_{{ $productDetailsEssential->id }}"
                                                                                data-qty="{{ $productDetailsEssential->total_stock_qty }}"
                                                                                data-comingsoon="{{ $productDetailsEssential->coming_soon }}"
                                                                                data-url="{{ route('dealerorder.store') }}"
                                                                                onClick="addToCart({{ $productDetailsEssential->id }})"><i
                                                                                    class="fe fe-check"></i></button>
                                                                            <button type="button"
                                                                                class="btn btn-icon mt-3  btn-danger"
                                                                                data-bs-placement="top"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-original-title="Remove From Cart"
                                                                                id="removeFromCart_{{ $productDetailsEssential->id }}"
                                                                                data-url="{{ route('dealerorder.destroy') }}"
                                                                                onClick="removeFromCart({{ $productDetailsEssential->id }})"><i
                                                                                    class="fe fe-x"></i></button>
                                                                            <div class="valid-feedback block text-bold mb-2"
                                                                                id="successCart_{{ $productDetailsEssential->id }}">
                                                                            </div>
                                                                            <div class="invalid-feedback block text-bold mb-2"
                                                                                id="errorCart_{{ $productDetailsEssential->id }}">
                                                                            </div>
                                                                        </td>
                                                                    @else
                                                                        <td class="wd-sm-10p">
                                                                            <a href="javascript:void(0)"
                                                                                class="btn btn-danger-gradient">Out Of
                                                                                Stock</a>
                                                                        </td>
                                                                    @endif
                                                                    {{-- <td class="wd-sm-10p">
                                                                        {{ $productDetailsEssential->catName }}/<br />
                                                                        {{ $productDetailsEssential->product_name }}</td> --}}
                                                                    <td class="wd-md-50p"><img class="wpx-250 hpx-200"
                                                                            src="{{ url($productDetailsEssential->product_image) }}" />
                                                                    </td>
                                                                    <td class="wd-sm-10p text-center">
                                                                        {{ $productDetailsEssential->product_price }}</td>
                                                                    <td class="wd-sm-10p">
                                                                        @if (
                                                                            $productDetailsEssential->coming_soon == '1' &&
                                                                                $productDetailsEssential->total_stock_qty - $productDetailsEssential->stock_coming_soon > 0)
                                                                            <h3 class="tag tag-blue">In Stock:&nbsp;
                                                                                <strong>{{ $productDetailsEssential->total_stock_qty - $productDetailsEssential->stock_coming_soon }}</strong>
                                                                            </h3>
                                                                            <br />
                                                                            <h5 class="tag tag-orange">Coming Soon:&nbsp;
                                                                                <strong>{{ $productDetailsEssential->stock_coming_soon }}</strong>
                                                                            </h5>
                                                                        @elseif (
                                                                            $productDetailsEssential->coming_soon == '1' &&
                                                                                $productDetailsEssential->total_stock_qty - $productDetailsEssential->stock_coming_soon <= 0)
                                                                            <h3 class="tag tag-blue">In Stock:&nbsp;
                                                                                <strong>0</strong>
                                                                            </h3>
                                                                            <br />
                                                                            <h5 class="tag tag-danger">Available For
                                                                                Order:&nbsp;
                                                                                <strong>{{ $productDetailsEssential->total_stock_qty }}</strong>
                                                                            </h5>
                                                                            <br />
                                                                            <h5 class="tag tag-orange">Coming Soon:&nbsp;
                                                                                <strong>{{ $productDetailsEssential->stock_coming_soon }}</strong>
                                                                            </h5>
                                                                        @else
                                                                            <h3 class="tag tag-blue">In Stock:&nbsp;
                                                                                <strong>{{ $productDetailsEssential->total_stock_qty }}</strong>
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
