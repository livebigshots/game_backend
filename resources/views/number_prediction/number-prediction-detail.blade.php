@extends('layouts.app')
@section('content')
    <div class="content-wrapper" style="overflow-y:auto; overflow-x:hidden">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Number Prediction Detail</h1>
                    </div>
                    <div class="col-sm-6">

                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a class="anchor" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="anchor" href="{{ route('number-prediction-list') }}">
                                    Number Prediction List
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                Number Prediction Detail
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
                <div class="col-md-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Number Prediction Details</h3>
                        </div>
                        <div class="card-body ">
                            <div class="tab-pane">
                                <table class="table table-sm">
                                    <tbody>
                                        <form action="{{ route('update-number') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $numberData->id }}">
                                            <tr style="width: 8%">
                                                <td><b>Game Type</b></td>
                                                <td>Number Prediction</td>
                                            </tr>
                                            <tr style="width: 8%">
                                                <td><b> Status </b></td>
                                                <td>
                                                    @if($numberData->status == 0)
                                                        Not Started
                                                    @elseif ($numberData->status == 1)
                                                        Running
                                                    @elseif($numberData->status == 2)
                                                        End
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr style="width: 8%">
                                                <td><b>Win</b></td>
                                                <td>{{ $numberData->totalNumberWin($numberData->id) }}</td>
                                            </tr>
                                            <tr style="width: 8%">
                                                <td><b>Lose</b></td>
                                                <td>{{ $numberData->totalNumberLose($numberData->id) }}</td>
                                            </tr>
                                            <tr style="width: 8%">
                                                <td><b> Result Number </b></td>
                                                <td>
                                                    <select name="result_number" id="" class="form-control">
                                                        <option value="" selected>- Select</option>
                                                        @foreach (\App\Models\GamePrediction::numberArray() as $key => $number)
                                                            <option value="{{ $number }}" {{ $numberData->result_color == $number ? 'selected' : '' }}>{{ $number }}</option>
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
                <div class="col-md-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title"><b>Game Amount</b> </h3>
                        </div>
                        <div class="card-body">
                            <div class="tab-pane">
                                <table class="table table-sm text-center">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">Number</th>
                                            <th style="width: 5%">1</th>
                                            <th style="width: 5%">2</th>
                                            <th style="width: 5%">3</th>
                                            <th style="width: 5%">4</th>
                                            <th style="width: 5%">5</th>
                                            <th style="width: 5%">6</th>
                                            <th style="width: 5%">7</th>
                                            <th style="width: 5%">8</th>
                                            <th style="width: 5%">9</th>
                                            <th style="width: 5%">10</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><b>Money</b></td>
                                            @php
                                                $total = 0.00;
                                            @endphp
                                            @foreach(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10'] as $number)
                                                <td>
                                                    @php
                                                        $numberData = $numberWithTotalAmount->where('game_number', $number)->first();
                                                        $total += $numberData ? $numberData->total_amount : '0.00';
                                                    @endphp
                                                    {{ $numberData ? $numberData->total_amount : '0.00'  }}
                                                </td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td><b>Total Amount</b></td>
                                            <td colspan="10">{{$total ?? 0.00}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title"><b>User Details </b> </h3>
                        </div>
                        <div class="card-body">
                            <div class="tab-pane">
                                <table class="table table-sm text-center">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">
                                                @sortablelink('first_name', 'Name')
                                            </th>
                                            <th style="width: 5%">
                                                @sortablelink('user_name', 'User name')
                                            </th>
                                            <th style="width: 5%">
                                                Amount
                                            </th>
                                            <th style="width: 5%">
                                                Selected Number
                                            </th>
                                            <th style="width: 5%">
                                                Result
                                            </th>
                                            <th style="width: 5%">
                                                Contact Number
                                            </th>
                                            <th style="width: 5%" class="text-center">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($users->count() == 0)
                                            <tr>
                                                <td colspan="5" class="text-muted text-center">No record found.</td>
                                            </tr>
                                        @endif
                                        @foreach ($users as $data)
                                            @if ($data->user->role == config('enums.USER_TYPE.USER'))
                                                <tr>
                                                    <td> {{ $data->user->first_name . ' ' . $data->user->last_name }} </td>
                                                    <td> {{ $data->user->username }} </td>
                                                    <td> {{ $data->amount }} </td>
                                                    <td> {{ $data->game_number }} </td>
                                                    <td> {{ $data->result_number == $data->game_number ? 'Win' : 'Lose' }} </td>
                                                    <td> {{ $data->user->mobile_number }} </td>
                                                    <td>
                                                        <a href="{{ url('user-detail', $data->user->id) }}"><button
                                                                class="btn btn-transparent" id="EditUser"><i
                                                                    class="fa-solid fa-eye"></i></button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        <div class="float-start" style="margin-left:2%; margin-top:1%; margin-bottom:1%">
                                            Showing <b>{{ $users->firstItem() }}</b> to <b>{{ $users->lastItem() }}</b> of
                                            <b>{{ $users->total() }}</b>
                                            records
                                        </div>
                                        <div class="float-end" style="margin-right:2%; margin-top:1%; margin-top:1%">
                                            {{ $users->links('pagination::bootstrap-4') }}
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
