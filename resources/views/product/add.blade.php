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
									<h1 class="page-title">Add Product</h1>
								</div>
								<div class="ms-auto pageheader-btn">
									<ol class="breadcrumb">
										<li class="breadcrumb-item"><a href="javascript:void(0);">Product</a></li>
										<li class="breadcrumb-item active" aria-current="page">Add</li>
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
												<p class="text-muted">Here you can create product</p>
                                                
												<div class="d-flex flex-column">
                                                    <form method="post" name="frm" id="frm" action="{{ route('product.store') }}" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label for="formFile" class="form-label">Product Category</label>
                                                            <select class="form-control" name="product_category" id="product_category">
                                                                <option value="">Choose Product Category </option>
                                                                <option value="Jute Bags" @selected(old('product_category') == 'Jute Bags')>Jute bags</option>
                                                                <option value="Juco Bags" @selected(old('product_category') == 'Juco Bags')>Juco bags</option>
                                                                <option value="Canvas/Jute Bags" @selected(old('product_category') == 'Canvas/Jute Bags')>Canvas/Jute bags</option>
                                                                <option value="Cotton Bags-120 gsm" @selected(old('product_category') == 'Cotton Bags-120 gsm')>Cotton Bags-120 gsm</option>
                                                                <option value="Cotton Bags-135 gsm" @selected(old('product_category') == 'Cotton Bags-135 gsm')>Cotton Bags-135 gsm</option>
                                                                <option value="Cotton Bags-150 gsm" @selected(old('product_category') == 'Cotton Bags-150 gsm')>Cotton Bags-150 gsm</option>
                                                                <option value="Cotton Bags-220 gsm" @selected(old('product_category') == 'Cotton Bags-220 gsm')>Cotton Bags-220 gsm</option>
                                                                <option value="600 gsm Canvas Bags" @selected(old('product_category') == '600 gsm Canvas Bags')>600 gsm Canvas Bags</option>
                                                                <option value="600 gsm Canvas Leather Combinations" @selected(old('product_category') == '600 gsm Canvas Leather Combinations')>600 gsm Canvas Leather Combinations</option>
                                                                <option value="Natural Leather Bags" @selected(old('product_category') == 'Natural Leather Bags')>Natural Leather Bags</option>
                                                                <option value="Joolood" @selected(old('product_category') == 'Joolood')>Joolood</option>
                                                                <option value="Non woven bags- Laminated" @selected(old('product_category') == 'Non woven bags- Laminated')>Non woven bags- Laminated</option>
                                                                <option value="Non woven bags- Unlaminated" @selected(old('product_category') == 'Non woven bags- Unlaminated')>Non woven bags- Unlaminated</option>
                                                                <option value="Canvas Bags-260 gsm" @selected(old('product_category') == 'Canvas Bags-260 gsm')>Canvas Bags-260 gsm</option>
                                                                
                                                                <option value="Backpacks" @selected(old('product_category') == 'Backpacks')>Backpacks</option>
                                                                <option value="Cooler bags" @selected(old('product_category') == 'Cooler bags')>Cooler bags</option>
                                                                <option value="String bags" @selected(old('product_category') == 'String bags')>String bags</option>
                                                                <option value="Foldable tote bags" @selected(old('product_category') == 'Foldable tote bags')>Foldable tote bags</option>
                                                                <option value="Foldable duffel bags" @selected(old('product_category') == 'Foldable duffel bags')>Foldable duffel bags</option>

                                                                
                                                              
                                                            </select>
                                                              @error('product_category')
                                                              <div class="invalid-feedback block">{{ $message }}</div>
                                                              @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="formFile" class="form-label">Product Code</label>
                                                            <input class="form-control" type="text" name="product_code" id="product_code" value="{{ old('product_code') }}">
                                                            @error('product_code')
                                                              <div class="invalid-feedback block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="formFile" class="form-label">Product Name</label>
                                                            <input class="form-control" type="text" name="product_name" id="product_name" value="{{ old('product_name') }}">
                                                            @error('product_name')
                                                              <div class="invalid-feedback block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="formFile" class="form-label">Product Image</label>
                                                            <input class="form-control file-input" type="file" id="product_image" name="product_image">
                                                            @error('product_image')
                                                              <div class="invalid-feedback block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="formFile" class="form-label">Product Size</label>
                                                            <input class="form-control" type="text" name="product_size" id="product_size" value="{{ old('product_size') }}">
                                                            @error('product_size')
                                                              <div class="invalid-feedback block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="formFile" class="form-label">Product Price (AED)</label>
                                                            <input class="form-control" type="text" name="product_price" id="product_price" value="{{ old('product_price') }}">
                                                            @error('product_price')
                                                            <div class="invalid-feedback block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group input-group align-items-center">
                                                            <label for="formFile" class="form-label me-4">Box Dimension</label>
                                                            <input type="number" name="length" id="length" class="form-control" placeholder="Length (cm)" value="{{ old('length') }}"/>
                                                            @error('length')
                                                            <span class="invalid-feedback block">{{ $message }}</span>
                                                            @enderror
                                                            <span class="input-group-addon">X</span>
                                                            <input type="number" name="width" id="width" class="form-control" placeholder="Width (cm)" value="{{ old('width') }}"/>
                                                            @error('width')
                                                            <span class="invalid-feedback block">{{ $message }}</span>
                                                            @enderror
                                                            <span class="input-group-addon">X</span>
                                                            <input type="number" name="height" id="height" class="form-control" placeholder="Height (cm)" value="{{ old('height') }}"/>
                                                            @error('height')
                                                            <span class="invalid-feedback block">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="formFile" class="form-label">No. Of Qty (per box)</label>
                                                            <input class="form-control" type="text" name="qty_per_box" id="qty_per_box" value="{{ old('qty_per_box') }}">
                                                            @error('qty_per_box')
                                                            <div class="invalid-feedback block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="formFile" class="form-label">Weight (Kgs per Box)</label>
                                                            <input class="form-control" type="number" name="weight_per_box" id="weight_per_box" value="{{ old('weight_per_box') }}">
                                                            @error('weight_per_box')
                                                            <div class="invalid-feedback block">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="formFile" class="form-label">Status</label>
                                                            <select class="form-control" name="status" id="status">
                                                                <option value="">Choose Status</option>
                                                                @foreach(App\Enums\CommonStatusEnums::values() as $key=>$value)
                                                                    <option value="{{ $key }}" @selected(old('status') == $key)>{{ $value }}</option>
                                                                @endforeach
                                                              </select>
                                                              @error('status')
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