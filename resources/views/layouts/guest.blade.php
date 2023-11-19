<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Game Prediction') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">

    <!-- Custome style -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <link rel="icon" href="{{ asset('Images/logo.png') }}">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#" class="brand-link">
                <img src="{{ asset('Images/logo.png') }}" alt="Game Prediction Logo" style="opacity: .8; width:50%">
            </a>
        </div>
        {{ $slot }}
    </div>

    <!-- jQuery -->
    <!-- <script src="{{ asset('js/jquery/jquery.min.js') }}" defer></script> -->
    </div>
    <!-- /.login-box -->
    <!-- <script src="{{ asset('js/validate.js') }}" ></script> -->
</body>

</html>
