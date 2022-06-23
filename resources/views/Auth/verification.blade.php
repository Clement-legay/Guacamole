@extends('Auth.appLogin')

@section('title', 'Verification')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card p-4 rounded">
                    <div class="row justify-content-center">
                        <div class="col-auto">
                            <h1 style="text-decoration: underline #9DA27A">Verification</h1>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($status == 'success')
                            <div class="alert alert-success text-center">
                                    Your account has been verified. You can now login.
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-auto">
                                    <a href="{{ route('login') }}" class="btn btn-primary">
                                        Login
                                    </a>
                                </div>
                            </div>
                        @elseif($status == 'already')
                            <div class="alert alert-danger text-center">
                                    Your account is already activated.
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-auto">
                                    <a href="{{ route('login') }}" class="btn btn-primary">
                                        Login
                                    </a>
                                </div>
                            </div>
                        @elseif($status == 'expired')
                            <div class="alert alert-danger text-center">
                                    Your verification link has expired.
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-auto">
                                    <a href="{{ route('login') }}" class="btn btn-primary">
                                        Login
                                    </a>
                                </div>
                            </div>
                        @elseif($status == 'pending')
                            <div class="alert alert-success text-center">
                                    We have emailed you with the verification link.
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-auto">
                                    <a href="{{ route('resend', base64_encode($user->id)) }}" class="btn btn-primary">
                                        Send another email
                                    </a>
                                </div>
                            </div>
                        @elseif($status == 'pendingLogin')
                            <div class="alert alert-success text-center">
                                We have already emailed you with the verification link.
                                <br>
                                <br>
                                If you have not received it, please click the button below to resend it.
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-auto">
                                    <a href="{{ route('resend', base64_encode($user->id)) }}" class="btn btn-primary">
                                        Send another email
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
