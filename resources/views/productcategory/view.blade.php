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
                        <h1 class="page-title">Manage Products Category</h1>
                    </div>
                    <div class="ms-auto pageheader-btn">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Product Category</a></li>
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
                                    <table class="table table-bordered text-nowrap border-bottom" id="basic-datatable">
                                        <thead>
                                            <tr>
                                                <th class="wd-15p border-bottom-0">S.No.</th>
                                                <th class="wd-15p border-bottom-0">Main Category</th>
                                                <th class="wd-15p border-bottom-0">Category</th>
                                                <th class="wd-25p border-bottom-0">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($allProductCategoryList as $productCategoryDetails)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ ucfirst($productCategoryDetails->main_category_name) }}</td>
                                                    <td>{{ $productCategoryDetails->category_name }}</td>
                                                    <td>
                                                        @if ($productCategoryDetails->status == 'active')
                                                            <a href="javascript:void(0)"
                                                                class="btn btn-primary-gradient">Active</a>
                                                        @endif
                                                        @if ($productCategoryDetails->status == 'inactive')
                                                            <a href="javascript:void(0)"
                                                                class="btn btn-danger-gradient">Blocked</a>
                                                        @endif

                                                        <a
                                                            href="{{ route('productcategory.edit', $productCategoryDetails->id) }}"><button
                                                                type="button" class="btn btn-icon  btn-primary"><i
                                                                    class="fe fe-edit"></i></button></a>
                                                        <a class="deleteUrl_{{ $productCategoryDetails->id }}"
                                                            onClick="confirmDelete({{ $productCategoryDetails->id }})"
                                                            data-url="{{ route('productcategory.destroy', $productCategoryDetails->id) }}"><button
                                                                type="button" class="btn btn-icon  btn-danger"
                                                                data-bs-toggle="modal" data-bs-target="#largemodal"><i
                                                                    class="fe fe-trash"></i></button></a>
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
