@extends('layouts.app')
@section('content')
    <div class="content-wrapper" style="overflow-y:auto; overflow-x:hidden">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Color Prediction Detail</h1>
                    </div>
                    <div class="col-sm-6">

                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a class="anchor" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="anchor" href="{{ route('color-prediction-list') }}">
                                    Color Prediction List
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                Color Prediction Detail
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
                            <h3 class="card-title">Color Prediction Details</h3>
                        </div>
                        <div class="card-body ">
                            <div class="tab-pane">
                                <table class="table table-sm">
                                    <tbody>
                                        <form action="{{ route('update-color') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $colorData->id }}">
                                            <tr style="width: 8%">
                                                <td><b>Game Type</b></td>
                                                <td>Color Prediction</td>
                                            </tr>
                                            <tr style="width: 8%">
                                                <td><b> Status </b></td>
                                                <td>
                                                    @if($colorData->status == 0)
                                                        Not Started
                                                    @elseif ($colorData->status == 1)
                                                        Running
                                                    @elseif($colorData->status == 2)
                                                        End
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr style="width: 8%">
                                                <td><b>Win</b></td>
                                                <td>{{ $colorData->totalWin($colorData->id) }}</td>
                                            </tr>
                                            <tr style="width: 8%">
                                                <td><b>Lose</b></td>
                                                <td>{{ $colorData->totalLose($colorData->id) }}</td>
                                            </tr>
                                            <tr style="width: 8%">
                                                <td><b> Result Color </b></td>
                                                <td>
                                                    <select name="result_color" id="" class="form-control">
                                                        <option value="" selected>- Select</option>
                                                        @foreach (\App\Models\GamePrediction::colorArray() as $key => $color)
                                                            <option value="{{ $color }}" {{ $colorData->result_color == $color ? 'selected' : '' }}>{{ $color }}</option>
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
                            <h3 class="card-title"><b>Game Amount</b></h3>
                        </div>
                        <div class="card-body">
                            <div class="tab-pane">
                                <table class="table table-sm text-center">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">Color</th>
                                            <th style="width: 5%">Red</th>
                                            <th style="width: 5%">Violet</th>
                                            <th style="width: 5%">Green</th>
                                            <th style="width: 5%">Orange</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><b>Money</b></td>
                                            @php
                                                $total = 0.00;
                                            @endphp
                                            @foreach(['red', 'violet', 'green', 'orange'] as $color)
                                                <td>
                                                    @php
                                                        $colorData = $colorsWithTotalAmount->where('game_color', $color)->first();
                                                        $total += $colorData ? $colorData->total_amount : '0.00';
                                                    @endphp
                                                    {{ $colorData ? $colorData->total_amount : '0.00' }}
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
                                                Selected Color
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
                                                    <td> {{ $data->game_color }} </td>
                                                    <td> {{ $data->result_color == $data->game_color ? 'Win' : 'Lose' }} </td>
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
