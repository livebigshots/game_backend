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
                                    <th style="width: 5%">Color</th>
                                    <th style="width: 5%; cursor:pointer;" class="result-click" data-color="red">Red</th>
                                    <th style="width: 5%; cursor:pointer;" class="result-click" data-color="violet">Violet</th>
                                    <th style="width: 5%; cursor:pointer;" class="result-click" data-color="green">Green</th>
                                    <th style="width: 5%; cursor:pointer;" class="result-click" data-color="orange">Orange</th>
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
                                                $runningColorData = $colorsWithTotalAmount->where('game_color', $color)->first();
                                                $total += $runningColorData ? $runningColorData->total_amount : '0.00';
                                            @endphp
                                            {{ $runningColorData ? $runningColorData->total_amount : '0.00' }}
                                        </td>
                                    @endforeach
                                </tr>
                                <tr style="color:red">
                                        <td style="text-align: left;"><b>Total Amount : </b></td>
                                        <td>{{$total ?? 0.00}}</td>
                                        <td></td>
                                        <td>Result : </td>
                                        <td>
                                            <label for="resultColor" class="result-color">{{$colorsWithTotalAmount[0]->result_color ?? '-'}}</label>
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
                                           Result Color
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
                                    @if ($colorData->count() == 0)
                                        <tr>
                                            <td colspan="8" class="text-muted">No record found.</td>
                                        </tr>
                                    @endif
                                    @foreach ($colorData as $data)

                                            <tr>
                                                <td> Color Prediction </td>
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
                                                <td>{{ $data->totalColorPredictUser($data->id) }}</td>
                                                <td>
                                                    <a href="{{ url('game-details', $data->id) }}"><button
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
            var color = $(this).data('color');
            var gameId = $('.gameId').val();
            $('.result-color').html(color);

            // Get the CSRF token from the hidden input field
            var csrfToken = $('input[name="_token"]').val();

            $.ajax({
                type: 'POST',
                url: '/update-color',
                data: {
                    result_color: color,
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
