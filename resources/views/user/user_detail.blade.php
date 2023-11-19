@extends('layouts.app')
@section('content')
    <div class="content-wrapper" style="overflow-y:auto; overflow-x:hidden">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>User Detail</h1>
                    </div>
                    <div class="col-sm-6">

                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a class="anchor" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="anchor" href="{{ route('user-list') }}">
                                    User List
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                User Detail
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
                            <h3 class="card-title">User Details</h3>
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
                                                <div class="text-center">
                                                    @if (empty($user->image))
                                                        <img class="profile-user-img img-fluid img-circle "
                                                            src="{{ asset('Images/avatar.png') }}">
                                                    @else
                                                        <img class="profile-user-img img-fluid img-circle" src="{{$user->image }}"
                                                            alt="User profile picture">
                                                    @endif
                                                    {{ $user->username }}
                                                </div><br>
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
                <div class="col-md-6">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Payment History</h3>
                        </div>
                        <div class="card-body">
                            <div class="tab-pane">
                                <table class="table table-sm text-center">
                                    <tbody>
                                        @if (!count($paymentHistories) > 0)
                                            <tr>
                                                <td colspan="4" class="text-muted text-center">No record found.</td>
                                            </tr>
                                        @else
                                            <th>Amount</th>
                                            <th>Payment Mode</th>
                                            <th>UPI ID</th>
                                            <th>Status</th>
                                        @foreach ($paymentHistories as $payment)

                                            <tr>
                                                <td>{{ $payment->amount }}</td>
                                                <td>{{ $payment->payment_mode }}</td>
                                                <td>{{ $payment->user_payment_id }}</td>
                                                <td>
                                                    @if($payment->status == "1")
                                                        {{ "Pending" }}
                                                    @elseif ($payment->status == "2")
                                                        {{ "Verified" }}
                                                    @elseif ($payment->status == "3")
                                                        {{ "Decline" }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        <div class="float-start" style="margin-left:2%; margin-top:1%; margin-bottom:1%">
                                            Showing <b>{{ $paymentHistories->firstItem() }}</b> to <b>{{ $paymentHistories->lastItem() }}</b> of
                                            <b>{{ $paymentHistories->total() }}</b>
                                            records
                                        </div>
                                        <div class="float-end" style="margin-right:2%; margin-top:1%; margin-top:1%">
                                            {{ $paymentHistories->links('pagination::bootstrap-4') }}
                                        </div>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Color Prediction List</h3>
                        </div>
                        <div class="card-body">
                            <div class="tab-pane">
                                <table class="table text-center">
                                    <th>Game Type</th>
                                    <th>Amount</th>
                                    <th>Result</th>
                                    <th>Action</th>
                                    <tbody>
                                        @if (count($colorPrediction) == 0)
                                            <tr>
                                                <td colspan="4">No Record Found</td>
                                            </tr>
                                        @endif
                                        @foreach ($colorPrediction as $color)
                                            <tr>
                                                <td>
                                                    Color Prediction
                                                </td>
                                                <td>
                                                    {{ $color->amount }}
                                                </td>
                                                <td>
                                                    @if ($color->result_color)
                                                        @if ($color->game_color == $color->result_color)
                                                            {{ "Win" }}
                                                        @else
                                                            {{ "Lose" }}
                                                        @endif
                                                    @else
                                                        {{ "Running" }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ url('game-details', $color->game_id) }}">
                                                        <button class="btn btn-transparent">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>

                                        @endforeach
                                        <div class="float-start" style="margin-left:2%; margin-top:1%; margin-bottom:1%">
                                            Showing <b>{{ $colorPrediction->firstItem() }}</b> to <b>{{ $colorPrediction->lastItem() }}</b> of
                                            <b>{{ $colorPrediction->total() }}</b>
                                            records
                                        </div>
                                        <div class="float-end" style="margin-right:2%; margin-top:1%; margin-top:1%">
                                            {{ $colorPrediction->links('pagination::bootstrap-4') }}
                                        </div>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Number Prediction List</h3>
                        </div>
                        <div class="card-body">
                            <div class="tab-pane">
                                <table class="table text-center">
                                    <th>Game Type</th>
                                    <th>Amount</th>
                                    <th>Result</th>
                                    <th>Action</th>
                                    <tbody>
                                        @if (count($numberPrediction) == 0)
                                            <tr>
                                                <td colspan="4">No Record Found</td>
                                            </tr>
                                        @endif
                                        @foreach ($numberPrediction as $number)
                                            <tr>
                                                <td>
                                                    Number Prediction
                                                </td>
                                                <td>
                                                    {{ $number->amount }}
                                                </td>
                                                <td>
                                                    @if ($number->result_number)
                                                        @if ($number->game_number == $number->result_number)
                                                            {{ "Win" }}
                                                        @else
                                                            {{ "Lose" }}
                                                        @endif
                                                    @else
                                                        {{ "Running" }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ url('number-game-details', $number->game_id) }}">
                                                        <button class="btn btn-transparent">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>

                                        @endforeach
                                        <div class="float-start" style="margin-left:2%; margin-top:1%; margin-bottom:1%">
                                            Showing <b>{{ $numberPrediction->firstItem() }}</b> to <b>{{ $numberPrediction->lastItem() }}</b> of
                                            <b>{{ $numberPrediction->total() }}</b>
                                            records
                                        </div>
                                        <div class="float-end" style="margin-right:2%; margin-top:1%; margin-top:1%">
                                            {{ $numberPrediction->links('pagination::bootstrap-4') }}
                                        </div>
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
