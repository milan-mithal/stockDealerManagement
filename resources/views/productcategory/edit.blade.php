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
                        <h1 class="page-title">Edit Product Category</h1>
                    </div>
                    <div class="ms-auto pageheader-btn">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Product Category</a></li>
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
                                <p class="text-muted">Here you can edit product category</p>

                                <div class="d-flex flex-column">
                                    <form method="post" name="frm" id="frm"
                                        action="{{ route('productcategory.update', $productCategoryDetail->id) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="formFile" class="form-label">Main Product Category</label>
                                            <select class="form-control" name="main_category_name" id="main_category_name">
                                                <option value="">Choose Main Product Category</option>
                                                @foreach (App\Enums\MainCategoryEnums::values() as $key => $value)
                                                    <option value="{{ $key }}" @selected(old('main_category_name', $productCategoryDetail->main_category_name) == $key)>
                                                        {{ $value }}</option>
                                                @endforeach
                                            </select>
                                            @error('main_category_name')
                                                <div class="invalid-feedback block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="formFile" class="form-label">Category Name</label>
                                            <input class="form-control" type="text" name="category_name"
                                                id="category_name"
                                                value="{{ old('category_name', $productCategoryDetail->category_name) }}">
                                            @error('category_name')
                                                <div class="invalid-feedback block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="formFile" class="form-label">Status</label>
                                            <select class="form-control" name="status" id="status">
                                                <option value="">Choose Status</option>
                                                @foreach (App\Enums\CommonStatusEnums::values() as $key => $value)
                                                    <option value="{{ $key }}" @selected(old('status', $productCategoryDetail->status) == $key)>
                                                        {{ $value }}</option>
                                                @endforeach
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <button type="submit" name="submit" id="submit"
                                            class="btn ripple btn-primary">Submit</button>
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
