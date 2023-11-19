@extends('layouts.app')
@section('content')
    <div class="content-wrapper" style="overflow-y:auto; overflow-x:hidden">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Contact Detail</h1>
                    </div>
                    <div class="col-sm-6">

                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a class="anchor" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a class="anchor" href="{{ route('contact-list') }}">
                                    Contact List
                                </a>
                            </li>
                            <li class="breadcrumb-item active">
                                Contact Detail
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
                            <h3 class="card-title">Contact Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="tab-pane">
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <td> Title </td>
                                            <td> {{ $contactData->title }} </td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>{{ !empty($contactData->email) ?$contactData->email : '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Message</td>
                                            <td> {{ $contactData->message }} </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">User Detail</h3>
                        </div>
                        <div class="card-body">
                            <div class="tab-pane">
                                <table class="table table-sm">
                                    <tbody>
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
