@extends('layouts.auth.base')

@section('body')
    <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center py-4 "
        style="background: #0033A0 ">
        <div class="row w-100 justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-6">
                @yield('content')
            </div>
        </div>
    </div>
@endsection
