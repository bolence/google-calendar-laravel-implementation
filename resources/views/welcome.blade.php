@extends('layouts.master')

@section('content')
    <div class="col-md-12 m-5">
        <div class="float-end">
            <a class="btn btn-primary" href="/google/auth/callback">
                Login with Google
            </a>
        </div>
    </div>
    <form-meeting-form-component />
@endsection
