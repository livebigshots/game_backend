@extends('layouts.app')
@section('content')
    <div class="content-wrapper" style="overflow-y:auto; overflow-x:hidden">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Payment Detail</h1>
                    </div>
                    <div class="col-sm-6">

                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a class="anchor" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="anchor" href="{{ route('payment-list') }}">
                                    Payment List
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                Payment Detail
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="container-fluid">
                @if (Session::has('message'))
                    <div class="alert alert-success {{ Session::get('alert-class', 'alert-success') }}" role="alert">
                        <button class="close" data-dismiss="alert">×</button>
                        {{ Session::get('message') }}</p>
                    </div>
                @endif
            </div>
        </section>
        <section class="content-header">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Payment Details</h3>
                        </div>
                        <div class="card-body ">
                            <div class="tab-pane">
                                <table class="table table-sm">
                                    <tbody>
                                        <form action="{{ route('update-payment') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $paymentData->id }}">
                                            <tr style="width: 8%">
                                                <td><b>User</b></td>
                                                <td>{{ $paymentData->user->username }}</td>
                                            </tr>
                                            <tr style="width: 8%">
                                                <td><b> Amount </b></td>
                                                <td>{{ $paymentData->amount }}</td>
                                            </tr>
                                            <tr style="width: 8%">
                                                <td><b> Payment Mode </b></td>
                                                <td>{{ $paymentData->payment_mode }}</td>
                                            </tr>
                                            <tr style="width: 8%">
                                                <td><b> User Payment Id </b></td>
                                                <td>{{ $paymentData->user_payment_id }}</td>
                                            </tr>
                                            <tr style="width: 8%">
                                                <td><b> Status </b></td>
                                                <td>
                                                    <select name="status" id="" class="form-control">
                                                        <option value="" selected>- Select</option>
                                                        @foreach (\App\Models\paymentHistory::paymentStatus() as $key => $status)
                                                            <option value="{{ $key }}" {{ $paymentData->status == $key ? 'selected' : '' }}>{{ $status }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr style="width: 8%">
                                                <td colspan="2"><button class="btn btn-info float-right px-4 my-2" type="submit">Save</button>
                                            </tr>
                                        </form>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title"><b>User Details </b> </h3>
                        </div>
                        <div class="card-body">
                            <div class="tab-pane">
                                <table class="table table-sm">
                                    <tbody>
                                        @if (!$user)
                                            <tr>
                                                <td colspan="5" class="text-muted text-center">No record found.</td>
                                            </tr>
                                        @else
                                            @if ($user->role == config('enums.USER_TYPE.USER'))
                                                <tr>
                                                    <td> Name </td>
                                                    <td> {{ $user->first_name . ' ' . $user->last_name }} </td>
                                                </tr>
                                                <tr>
                                                    <td>Email</td>
                                                    <td>{{ $user->email }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Mobile Number</td>
                                                    <td> {{ $user->mobile_number }} </td>
                                                </tr>
                                                <tr>
                                                    <td>Wallet Amount</td>
                                                    <td>{{ $walletAmount }}</td>
                                                </tr>
                                            @endif
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection
