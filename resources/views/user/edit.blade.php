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
                        @if (Auth::user()->role == 'dealer')
                            Edit Sub Dealer
                        @else
                            Edit User
                        @endif
                    </div>
                    <div class="ms-auto pageheader-btn">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">User</a></li>
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
                                <p class="text-muted">Here you can edit user</p>
                                <div class="d-flex flex-column">
                                    <form method="post" name="frm" id="frm"
                                        action="{{ route('user.update', $userDetails->id) }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="formFile" class="form-label">Name</label>
                                            <input class="form-control" type="text" name="name" id="name"
                                                value="{{ old('name', $userDetails->name) }}">
                                            @error('name')
                                                <div class="invalid-feedback block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="formFile" class="form-label">User Email Id</label>
                                            <input class="form-control" type="text" name="email" id="email"
                                                value="{{ old('email', $userDetails->email) }}">
                                            @error('email')
                                                <div class="invalid-feedback block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="formFile" class="form-label">User Company Name</label>
                                            <input class="form-control" type="text" name="dealer_name" id="dealer_name"
                                                value="{{ old('dealer_name', $userDetails->dealer_name) }}">
                                            @error('dealer_name')
                                                <div class="invalid-feedback block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="formFile" class="form-label">User Company Address</label>
                                            <textarea class="form-control" type="text" name="address" id="address">{{ old('address', $userDetails->address) }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="formFile" class="form-label">User Phone No.</label>
                                            <input class="form-control" type="text" name="phone_no" id="phone_no"
                                                value="{{ old('phone_no', $userDetails->phone_no) }}">
                                            @error('phone_no')
                                                <div class="invalid-feedback block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="formFile" class="form-label">User Region</label>
                                            <input class="form-control" type="text" name="region" id="region"
                                                value="{{ old('region', $userDetails->region) }}">
                                            @error('region')
                                                <div class="invalid-feedback block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="formFile" class="form-label">User Community</label>
                                            <input class="form-control" type="text" name="community" id="community"
                                                value="{{ old('community', $userDetails->community) }}">
                                            @error('community')
                                                <div class="invalid-feedback block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="formFile" class="form-label">Choose Currency</label>
                                            <select class="form-control" name="currency" id="currency">
                                                <option value="">Choose Currency</option>
                                                @foreach ($allcurrencyList as $currency)
                                                    <option value="{{ $currency->country_currency }}"
                                                        @selected(old('currency', $userDetails->currency) == $currency->country_currency)>
                                                        {{ $currency->country . ' - ' . $currency->country_currency }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('currency')
                                                <div class="invalid-feedback block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        @if (Auth::user()->role == 'admin')
                                            <div class="form-group">
                                                <label for="formFile" class="form-label">Role</label>
                                                <select class="form-control" name="role" id="role">
                                                    <option value="">Choose Role</option>
                                                    @foreach (App\Enums\UserRolesEnums::values() as $key => $value)
                                                        <option value="{{ $key }}" @selected(old('role', $userDetails->role) == $key)>
                                                            {{ str_replace('_', ' ', $value) }}</option>
                                                    @endforeach
                                                </select>
                                                @error('role')
                                                    <div class="invalid-feedback block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        @else
                                            <div class="form-group">
                                                <label for="formFile" class="form-label">Role</label>
                                                <select class="form-control" name="role" id="role">
                                                    <option value="subdealer">Sub Dealer</option>
                                                </select>
                                                @error('role')
                                                    <div class="invalid-feedback block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        @endif
                                        @if (Auth::user()->role == 'admin')
                                            <div class="form-group subdealer-list">
                                                <label for="formFile" class="form-label">Choose Dealer</label>
                                                <select class="form-control" name="dealer_id" id="dealer_id">
                                                    <option value="">Choose Dealer</option>
                                                    @foreach ($allDealerList as $dealer)
                                                        <option value="{{ $dealer->id }}" @selected(old('dealer_id', $userDetails->dealer_id) == $dealer->id)>
                                                            {{ $dealer->dealer_name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('dealer_id')
                                                    <div class="invalid-feedback block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        @else
                                            <div class="form-group">
                                                <label for="formFile" class="form-label">Dealer Details</label>
                                                <select class="form-control" name="dealer_id" id="dealer_id">
                                                    <option value="{{ Auth::user()->id }}">
                                                        {{ Auth::user()->dealer_name }}</option>
                                                </select>
                                                @error('dealer_id')
                                                    <div class="invalid-feedback block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        @endif
                                        @if (Auth::user()->role == 'admin')
                                            <div class="form-group">
                                                <label for="formFile" class="form-label">Choose Percentage Option</label>
                                                <select class="form-control" name="discount_option" id="discount_option">
                                                    <option value="">Choose</option>
                                                    <option value="0" @selected(old('discount_option', $percentageOption) == '0')>No Percentage
                                                    </option>
                                                    <option value="1" @selected(old('discount_option', $percentageOption) == '1')>Dealer Percentage -
                                                        All
                                                    </option>
                                                    <option value="2" @selected(old('discount_option', $percentageOption) == '2')>Dealer Percentage -
                                                        Natural
                                                    </option>
                                                    <option value="3" @selected(old('discount_option', $percentageOption) == '3')>Dealer Percentage -
                                                        Essential
                                                    </option>
                                                    <option value="4" @selected(old('discount_option', $percentageOption) == '4')>Product wise
                                                        Percentage
                                                    </option>
                                                </select>
                                                @error('discount_option')
                                                    <div class="invalid-feedback block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="formFile" class="form-label">Dealer Percentage</label>
                                                <input class="form-control" type="text" name="percentage"
                                                    maxlength="2" id="percentage"
                                                    value="{{ old('percentage', $percentage) }}">
                                                @error('percentage')
                                                    <div class="invalid-feedback block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="formFile" class="form-label">Increase/Decrease</label>
                                                <select class="form-control" name="inc_dec" id="inc_dec">
                                                    <option value="">Choose</option>
                                                    <option value="+" @selected(old('inc_dec', $incDec) == '+')>+</option>
                                                    <option value="-" @selected(old('inc_dec', $incDec) == '-')>-</option>
                                                </select>
                                                @error('inc_dec')
                                                    <div class="invalid-feedback block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        @endif
                                        <div class="form-group">
                                            <label for="formFile" class="form-label">VAT No.</label>
                                            <input class="form-control" type="text" name="identification_no"
                                                id="identification_no"
                                                value="{{ old('identification_no', $userDetails->identification_no) }}">
                                            @error('identification_no')
                                                <div class="invalid-feedback block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="formFile" class="form-label">Status</label>
                                            <select class="form-control" name="status" id="status">
                                                <option value="">Choose Status</option>
                                                @foreach (App\Enums\UserStatusEnums::values() as $key => $value)
                                                    <option value="{{ $key }}" @selected(old('status', $userDetails->status) == $key)>
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
@section('script')
    <script>
        $(function() {
            $('#role').on('change', function() {
                let roleStatus = this.value;
                if (roleStatus == 'subdealer') {
                    $('.subdealer-list').show();
                    $('.subdealer-percentage').show();
                } else {
                    $('.subdealer-list').hide();
                    $('.subdealer-percentage').hide();
                }
            });
            let selectedRole = $('#role').find(":selected").val();;
            if (selectedRole == 'subdealer') {
                $('.subdealer-list').show();
                $('.subdealer-percentage').show();
            } else {
                $('.subdealer-list').hide();
                $('.subdealer-percentage').hide();
            }
        });
    </script>
@endsection
