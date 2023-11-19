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
                        @if (Session::has('message'))
                            <p class="alert {{ Session::get('alert-class', 'alert-success') }}">
                                {{ Session::get('message') }}</p>
                        @endif
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">
                                @foreach (explode('-', $uri) as $info)
                                    {{ ucfirst($info) }}
                                @endforeach
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- /.container-fluid -->

            <div class="col-md-12">
                <div class="card card-info card-outline">
                    <div class="card-header d-flex justify-content-between align-items-center" style="display: flex;justify-content: space-between;align-items: center;">
                        <div>
                            <h3 class="card-title"><b>Game Amount</b></h3>
                        </div>
                        <div>
                            <button class="btn btn-info px-4 my-2 refresh-button" type="submit">Refresh</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-pane">
                            <table class="table table-sm text-center">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">Number</th>
                                        <th style="width: 5%; cursor:pointer;" class="result-click" data-number="1">1</th>
                                        <th style="width: 5%; cursor:pointer;" class="result-click" data-number="2">2</th>
                                        <th style="width: 5%; cursor:pointer;" class="result-click" data-number="3">3</th>
                                        <th style="width: 5%; cursor:pointer;" class="result-click" data-number="4">4</th>
                                        <th style="width: 5%; cursor:pointer;" class="result-click" data-number="5">5</th>
                                        <th style="width: 5%; cursor:pointer;" class="result-click" data-number="6">6</th>
                                        <th style="width: 5%; cursor:pointer;" class="result-click" data-number="7">7</th>
                                        <th style="width: 5%; cursor:pointer;" class="result-click" data-number="8">8</th>
                                        <th style="width: 5%; cursor:pointer;" class="result-click" data-number="9">9</th>
                                        <th style="width: 5%; cursor:pointer;" class="result-click" data-number="10">10</th>
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
                                                    $runningNumberData = $numberWithTotalAmount->where('game_number', $number)->first();
                                                    $total += $runningNumberData ? $runningNumberData->total_amount : '0.00';
                                                @endphp
                                                {{ $runningNumberData ? $runningNumberData->total_amount : '0.00';  }}
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr style="color:red">
                                        <td colspan="2" style="text-align: left;"><b>Total Amount</b></td>
                                        <td> : </td>
                                        <td>{{$total ?? 0.00}}</td>
                                        <td colspan="3"></td>
                                        <td colspan="2">Result</td>
                                        <td> : </td>
                                        <td>
                                            <label for="resultNumber" class="result-number">{{$numberWithTotalAmount[0]->result_number ?? '-'}}</label>
                                        </td>
                                        <input type="text" class="gameId" style="display:none;" value="{{$runningGameId}}">
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                @foreach (explode('-', $uri) as $info)
                                    {{ ucfirst($info) }}
                                @endforeach
                            </h3>

                        </div>
                        <div class="card-body p-0" style="overflow-x:auto;">
                            <table class="table table-striped projects text-center">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">
                                            @sortablelink('game_type', 'Game Type')
                                        </th>
                                        <th style="width: 5%">
                                            @sortablelink('status', 'Status')
                                        </th>
                                        <th style="width: 5%">
                                           Result Number
                                        </th>
                                        <th style="width: 5%">
                                            Total User
                                        </th>
                                        <th style="width: 5%" class="text-center">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @if ($numberData->count() == 0)
                                        <tr>
                                            <td colspan="8" class="text-muted">No record found.</td>
                                        </tr>
                                    @endif
                                    @foreach ($numberData as $data)

                                            <tr>
                                                <td> Number Prediction </td>
                                                <td>
                                                    <!-- @if($data->status == 0)
                                                        Not Started
                                                    @elseif ($data->status == 1)
                                                        Running
                                                    @elseif($data->status == 2)
                                                        End
                                                    @endif -->
                                                    @if($loop->index === 0)
                                                        Running
                                                    @else
                                                        End
                                                    @endif
                                                </td>
                                                <td> {{ !empty($data->result_color) ? $data->result_color : '-' }}</td>
                                                <td>{{ $data->totalNumberPredictUser($data->id) }}</td>
                                                <td>
                                                    <a href="{{ url('number-game-details', $data->id) }}"><button
                                                        class="btn btn-transparent" id="EditUser"><i
                                                        class="fa-solid fa-eye"></i></button>
                                                    </a>
                                                </td>
                                            </tr>

                                    @endforeach
                                </tbody>
                            </table>
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


@csrf
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js" integrity="sha512-WMEKGZ7L5LWgaPeJtw9MBM4i5w5OSBlSjTjCtSnvFJGSVD26gE5+Td12qN5pvWXhuWaWcVwF++F7aqu9cvqP0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function() {
        $('.result-click').click(function() {
            var number = $(this).data('number');
            var gameId = $('.gameId').val();
            $('.result-number').html(number);

            // Get the CSRF token from the hidden input field
            var csrfToken = $('input[name="_token"]').val();

            $.ajax({
                type: 'POST',
                url: '/update-number',
                data: {
                    result_number: number,
                    id: gameId,
                    _token: csrfToken // Include the CSRF token in the data
                },
                success: function(response) {
                },
                error: function(error) {
                }
            });
        });

        $('.refresh-button').click(function () {
            window.location.reload();
        })
    });
</script>
