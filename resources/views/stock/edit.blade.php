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
									<h1 class="page-title">Edit Stock</h1>
								</div>
								<div class="ms-auto pageheader-btn">
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="javascript:void(0);">Stock</a></li>
										<li class="breadcrumb-item active" aria-current="page">Edit</li>
									</ol>
								</div>
							</div>
							<!-- PAGE-HEADER END -->

							<!-- row -->
							<div class="row row-deck">
								<div class="col-lg-12 col-md-">
										<div class="card custom-card">
											
												
											
											<div class="card-body">
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
												<p class="text-muted">Here you can edit stock for product</p>
                                                <div class="valid-feedback block text-bold mb-2">Current Stock Available: {{ $stockDetail->stock_qty }}</div>
                                                <div class="invalid-feedback block text-bold mb-2">New stock quantity will get updated</div>
												<div class="d-flex flex-column">
                                                    <form method="post" name="frm" id="frm" action="{{ route('stock.update', $stockDetail->id) }}" enctype="multipart/form-data">
                                                        @csrf
                                                       
                                                        <div class="form-group">
                                                            <label for="formFile" class="form-label">Product Code</label>
                                                            <input class="form-control" type="text" readonly name="product_code" id="product_code" value="{{ old('product_code',$stockDetail->product_code) }}">
                                                            @error('product_code')
                                                              <div class="invalid-feedback block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="formFile" class="form-label">Coming Soon</label>
                                                            <select class="form-control" name="coming_soon" id="coming_soon">
                                                                    <option value="0" @selected(old('coming_soon',$stockDetail->coming_soon) == '0')>No</option>
                                                                    <option value="1" @selected(old('coming_soon',$stockDetail->coming_soon) == '1')>Yes</option>
                                                              </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="formFile" class="form-label">Enter Coming Soon Quantity</label>
                                                            <input class="form-control" type="text" name="stock_coming_soon" id="stock_coming_soon" value="{{ old('stock_coming_soon', $stockDetail->stock_coming_soon) }}">
                                                            @error('stock_coming_soon')
                                                              <div class="invalid-feedback block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="formFile" class="form-label">Enter Total Stock Quantity</label>
                                                            <div class="invalid-feedback block text-bold mb-2">Total Stock Quantity = Quantity in Hand + Coming Soon Quantity</div>
                                                            <input class="form-control" type="text" name="stock_qty" id="stock_qty" value="{{ old('stock_qty',$stockDetail->stock_qty ) }}">
                                                            @error('stock_qty')
                                                              <div class="invalid-feedback block">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="formFile" class="form-label">Total Stock Sold Till Today</label>
                                                            <input class="form-control" type="text" readonly name="stock_sold_qty" id="stock_sold_qty" value="{{ old('stock_sold_qty',$stockDetail->stock_sold_qty) }}">
                                                            @error('stock_sold_qty')
                                                              <div class="invalid-feedback block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="formFile" class="form-label">Set Minimum Quantity Alert</label>
                                                            <input class="form-control" type="text" name="stock_min_qty" id="stock_min_qty" value="{{ old('stock_min_qty',$stockDetail->stock_min_qty) }}">
                                                            @error('stock_min_qty')
                                                              <div class="invalid-feedback block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                       
                                                        <button type="submit" name="submit" id="submit" class="btn ripple btn-primary">Submit</button>
                                                    </form>
												</div>
											</div>
										</div>
								</div>
							
							</div>
							<!-- /row -->

						



						</div>
					</div>
				</div>
				<!-- CONTAINER CLOSED -->
@endsection