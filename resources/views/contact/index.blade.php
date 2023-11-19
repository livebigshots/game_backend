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
                        </div>
                        <div class="card-body p-0" style="overflow-x:auto;">
                            <table class="table table-striped projects text-center">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">
                                            User Name
                                        </th>
                                        <th style="width: 5%">
                                            Title
                                        </th>
                                        <th style="width: 5%">
                                            Message
                                        </th>
                                        <th style="width: 5%" class="text-center">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($contactData->count() == 0)
                                        <tr>
                                            <td colspan="8" class="text-muted">No record found.</td>
                                        </tr>
                                    @endif
                                    @foreach ($contactData as $contact)
                                        @php
                                        $inputString = $contact->message;
                                        $maxChars = 50;

                                        if (strlen($inputString) <= $maxChars) {
                                            $firstPart = $inputString;
                                            $secondPart = '';
                                        } else {
                                            $firstPart = substr($inputString, 0, $maxChars). '...';
                                        }
                                        @endphp
                                        <tr>
                                            <td> {{ $contact->user->first_name . ' ' . $contact->user->last_name }} </td>
                                            <td> {{ $contact->title }} </td>
                                            <td> {{ $firstPart }} </td>
                                            <td>
                                                <a href="{{ url('contact-detail', $contact->id) }}"><button
                                                    class="btn btn-transparent" id="EditUser"><i
                                                    class="fa-solid fa-eye"></i></button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="float-start" style="margin-left:2%; margin-top:1%; margin-bottom:1%">
                                Showing <b>{{ $contactData->firstItem() }}</b> to <b>{{ $contactData->lastItem() }}</b> of
                                <b>{{ $contactData->total() }}</b>
                                records
                            </div>
                            <div class="float-end" style="margin-right:2%; margin-top:1%; margin-top:1%">
                                {{ $contactData->links('pagination::bootstrap-4') }}
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
