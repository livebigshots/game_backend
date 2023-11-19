@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Dashboard</h1>
                    </div>

                </div>
            </div>
            <!-- /.container-fluid -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $totalUser }}</h3>

                                    <p>Total Users</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person"></i>
                                </div>

                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>{{ $totalColorPayment }}</h3>
                                    <p>Total Color Prediction Payment</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-cash"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-gray">
                                <div class="inner">
                                    <h3>{{ $totalNumberPayment }}</h3>
                                    <p>Total Number Prediction Payment</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-cash"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-4 col-6">
                            <!-- small box -->
                            <div class="small-box bg-blue">
                                <div class="inner">
                                    <h3>{{ $totalWithdraw }}</h3>
                                    <p>Total Withdraw</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-cash"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
            </section>
        </section>
    </div>
@endsection
