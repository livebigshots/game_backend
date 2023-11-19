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

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                @foreach (explode('-', $uri) as $info)
                                    {{ ucfirst($info) }}
                                @endforeach
                            </h3>
                            <div class="card-tools float-right">
                                <form action="{{ route($uri) }}" name="filterForm" method="GET" class="pull-right">
                                    @csrf
                                    <table class="input-group input-group-sm" align="right">
                                        <tr style="width:150px">
                                            <td>
                                                <label for="date">Search </label><br>
                                                <input type="text" name="search" id="search" class="form-control"
                                                    value="{{ $searchData }}" />
                                            </td>
                                            <td><br>
                                                <button type="submit" id="submit" style="margin-left:20px; margin-top:10px;"
                                                    class="btn btn-primary button">Search</button>&nbsp;
                                                <button type="reset" id="resetFilter" style="margin-top:10px;"
                                                    class="btn btn-primary button" value="reset"
                                                    onclick="window.location='{{ route($uri) }}'">Reset</button>
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>

                        </div>
                        <div class="card-body p-0" style="overflow-x:auto;">
                            <table class="table table-striped projects text-center">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">
                                            @sortablelink('first_name', 'Name')
                                        </th>
                                        <th style="width: 5%">
                                            @sortablelink('username', 'User name')
                                        </th>
                                        <th style="width: 5%">
                                            Amount
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
                                            <td colspan="8" class="text-muted">No record found.</td>
                                        </tr>
                                    @endif
                                    @foreach ($users as $data)
                                        @if ($data->role == config('enums.USER_TYPE.USER'))
                                            <tr>
                                                <td> {{ $data->first_name . ' ' . $data->last_name }} </td>
                                                <td> {{ $data->username }} </td>
                                                <td> {{ !empty($data->wallet) && !empty($data->wallet->amount) ? $data->wallet->amount : 0 }} </td>
                                                <td> {{ $data->mobile_number }} </td>
                                                <td>
                                                    <a href="{{ url('user-detail', $data->id) }}"><button
                                                        class="btn btn-transparent" id="EditUser"><i
                                                        class="fa-solid fa-eye"></i></button>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="float-start" style="margin-left:2%; margin-top:1%; margin-bottom:1%">
                                Showing <b>{{ $users->firstItem() }}</b> to <b>{{ $users->lastItem() }}</b> of
                                <b>{{ $users->total() }}</b>
                                records
                            </div>
                            <div class="float-end" style="margin-right:2%; margin-top:1%; margin-top:1%">
                                {{ $users->links('pagination::bootstrap-4') }}
                            </div>
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
