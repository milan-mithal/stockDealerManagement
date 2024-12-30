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
                                        @if (count($allCartList) > 0)
                                            <button id="button" class="btn btn-danger-gradient mb-4 data-table-btn"
                                                data-bs-target="#modalInput" data-bs-toggle="modal"
                                                href="javascript:void(0)">Provide Pickup Details</button>
                                            <p><a href="{{ route('dealer.index') }}">Click here </a> to add more product in
                                                order list</p>
                                            <button class="btn btn-danger mt-2 mb-3" data-bs-toggle="modal"
                                                data-bs-target="#smallmodal">Delete All Products In List</button>
                                        @else
                                            <p><a href="{{ route('dealer.index') }}">Click here </a> to add products in
                                                order list</p>
                                        @endif
                                        <thead>
                                            <tr>
                                                <th class="wd-10p border-bottom-0">Code</th>
                                                <th class="wd-10p border-bottom-0">Product Name</th>
                                                <th class="wd-10p border-bottom-0">Image</th>
                                                <th class="wd-10p border-bottom-0">Price ({{ Auth::user()->currency }})
                                                </th>
                                                <th class="wd-10p border-bottom-0">Total Stock Available</th>
                                                <th class="wd-10p border-bottom-0">Order Stock</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($allCartList as $productDetails)
                                                <tr id="row_{{ $productDetails->id }}">
                                                    <td>{{ $productDetails->product_code }}</td>
                                                    <td>{{ $productDetails->product_name }}</td>
                                                    <td><img class="hpx-100"
                                                            src="{{ url($productDetails->product_image) }}" /></td>
                                                    <td>{{ Helper::calculatePrice($productDetails->product_price, $productDetails->percentage, $productDetails->main_category) }}
                                                    </td>
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
                                                    <td class="wd-20p"><input type="number" class="wp-50"
                                                            id="order_qty_{{ $productDetails->id }}"
                                                            value="{{ $productDetails->order_quantity }}"
                                                            placeholder="0" />
                                                        <br />
                                                        <button type="button" class="btn btn-icon mt-3  btn-primary"
                                                            data-bs-placement="top" data-bs-toggle="tooltip"
                                                            data-bs-original-title="Add To Cart"
                                                            id="addToCart_{{ $productDetails->id }}"
                                                            data-qty="{{ $productDetails->total_stock_qty }}"
                                                            data-comingsoon="{{ $productDetails->coming_soon }}"
                                                            data-url="{{ route('dealerorder.store') }}"
                                                            onClick="addToCart({{ $productDetails->id }})"><i
                                                                class="fe fe-check"></i></button>
                                                        <button type="button" class="btn btn-icon mt-3  btn-danger"
                                                            data-bs-placement="top" data-bs-toggle="tooltip"
                                                            data-bs-original-title="Remove From Cart"
                                                            id="removeFromCart_{{ $productDetails->id }}"
                                                            data-url="{{ route('dealerorder.destroy') }}"
                                                            onClick="removeFromCart({{ $productDetails->id }})"><i
                                                                class="fe fe-x"></i></button>
                                                        <div class="valid-feedback block text-bold mb-2"
                                                            id="successCart_{{ $productDetails->id }}"></div>
                                                        <div class="invalid-feedback block text-bold mb-2"
                                                            id="errorCart_{{ $productDetails->id }}"></div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if (count($allCartList) > 0)
                                        <button id="button" class="btn btn-danger-gradient mb-4 data-table-btn"
                                            data-bs-target="#modalInput" data-bs-toggle="modal"
                                            href="javascript:void(0)">Provide Pickup Details</button>
                                        <p><a href="{{ route('dealer.index') }}">Click here </a> to add more product in
                                            order list</p>
                                    @else
                                        <p><a href="{{ route('dealer.index') }}">Click here </a> to add products in order
                                            list</p>
                                    @endif
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
                    <form method="post" name="frm" id="frm" action="{{ route('dealerorder.create') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="form-label text-muted">Pickup By</label>
                            <div class="input-group">
                                <select class="form-control order_status" name="delivery_by" id="delivery_by">
                                    <option value=""> Pickup By</option>
                                    @foreach (App\Enums\DeliveryTypeEnums::values() as $key => $value)
                                        <option value="{{ $key }}" @selected(old('delivery_by') == $key)>
                                            {{ $value }}</option>
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
                    <button type="submit" name="submit" id="submit" class="btn btn-primary-gradient">Place
                        Order</button>
                    <a href="javascript:void(0);" class="btn btn-light" data-bs-dismiss="modal">Close</a>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal  fade" id="smallmodal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Empty Cart</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure want to delete all products in list?</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button class="btn btn-primary"
                        onClick="javascript:location.href='{{ route('dealerorder.emptycart') }}'">Yes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @if ($errors->any())
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
        $('.order_status').change(function() {
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
