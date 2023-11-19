<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Game Prediction') }}</title>
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('css/plugins/fontawesome-free/css/all.min.css') }}">

        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="{{ asset('css/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">

        <!-- Date  -->
        <link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>

        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="{{ asset('css/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">


        <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">

        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

        <!-- Custome style -->
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

        <link rel="icon" href="{{ asset('images/logo.png') }}">
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">

            @include('layouts.partials.header')
            @include('layouts.partials.sidebar')
            <!-- Page Content -->

            @yield('content')

            @include('layouts.partials.footer')
        </div>
        @stack('child-scripts')

    </body>
</html>
