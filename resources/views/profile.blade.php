@extends('layouts.app')
@section('content')

    <div class="content-wrapper" style="overflow-y:auto; overflow-x:hidden">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>
                            @foreach (explode('-', $uri) as $info)
                                {{ ucfirst($info) }}
                            @endforeach
                        </h1><br>
                        @if(Session::has('message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
                        @endif
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">
                                @foreach(explode('-', $uri) as $info)
                                    {{ucfirst($info)}}
                                @endforeach
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.container-fluid -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                               User Profile
                            </h3>
                        </div>

                        <div class="card-body p-4">
                            <div class="tab-pane" id="settings">
                                <form class="form-horizontal" action="{{ route('profile') }}" name="profile"
                                    method="POST">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="firstName" class="col-form-label">Name</label>
                                        <input type="text" class="form-control" name="firstname" id="firstName"
                                        readonly  value="{{ $users->first_name.' '. $users->last_name }}" placeholder="firstName">
                                    </div>
                                    <div class="form-group row">
                                        <label for="email" class="col-form-label">Email</label>
                                        <input type="email" class="form-control" name="email" id="email"
                                        readonly  value="{{ $users->email }}" placeholder="Name">
                                    </div>
                                    <div class="form-group row">
                                        <label for="conatct" class="col-form-label">Mobile No.</label>
                                        <input type="text" class="form-control" id="mobile"
                                            readonly value="{{ $users->mobile_number }}" name="mobile"
                                                placeholder="Mobilet number">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Admin Account Details</h3>
                        </div>
                        <div class="card-body ">
                            <form class="form-horizontal" action="{{ route('change-account-detail') }}"
                                name="changeAdminAccountForm" id="changeAdminAccountForm" method="POST" enctype="multipart/form-data">
                                    @csrf
                                <div class="text-center">
                                    @if (!empty($adminAccount->image))
                                        <img class="profile-user-img img-fluid"
                                            src="{{ asset('storage/admin_account/'.$adminAccount->image) }}">
                                    @endif
                                </div><br>
                                <div class="tab-pane">
                                    <input type="file" name="image"/>
                                    @error('image')
                                        <div class="validation-error">{{ $message }}</div>
                                    @enderror
                                </div><br>
                                <div class="form-group row">
                                    <label class="col-form-label">UPI ID</label>
                                    <input type="text" name="upi_id" placeholder="Enter UPI Id" class="form-control  @error('upi_id') is-invalid @enderror" value="{{ !empty($adminAccount->upi_id) ? $adminAccount->upi_id : '' }}"/>
                                    @error('upi_id')
                                        <div class="validation-error">{{ $message }}</div>
                                    @enderror
                                </div><br>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-info">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                Change Password
                            </h3>
                        </div>

                        <div class="card-body p-4">
                            <div class="tab-pane">
                                <form class="form-horizontal" action="{{ route('change-password') }}"
                                    name="changePasswordForm" id="changePasswordForm" method="POST">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="oldpassword" class="col-form-label">Old Password</label>
                                        <input type="password"
                                            class="form-control @error('old_password') is-invalid @enderror"
                                            name="old_password" id="old_password" placeholder="Old Password">
                                        @error('old_password')
                                            <div class="validation-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label for="password" class="col-form-label">Password</label>
                                        <input type="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror" id="password"
                                            placeholder="Password">
                                            @error('password')
                                                <div class="validation-error">{{ $message }}</div>
                                            @enderror
                                    </div>
                                    <div class="form-group row">
                                        <label for="confirmPassword" class="col-form-label">Confirm
                                            Password</label>
                                            <input type="password"
                                                class="form-control @error('confirm_password') is-invalid @enderror"
                                                id="confirm_password" name="confirm_password"
                                                placeholder="Confirm Password">
                                            @error('confirm_password')
                                                <div class="validation-error">{{ $message }}</div>
                                            @enderror
                                    </div>

                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-info">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
@endsection

<!-- Validation -->
<!-- @push('child-scripts')
    <script src="{{ asset('js/validate.js') }}"></script>
@endpush -->
