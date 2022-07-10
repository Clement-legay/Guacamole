@extends('Auth.appLogin')

@section('title', 'Login')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-5 col-xl-4">
                <div class="card p-4 rounded">
                    <div class="row justify-content-around">
                        <div class="col-auto">
                            <h1 class="font-bold underline" style="text-decoration: underline #9DA27A">Login</h1>
                        </div>
                        <div class="col-auto">
                            <a href="{{route('register')}}" class="modal-title text-black-50" style="font-size: 2em; text-decoration: none">Register</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group">
                                <label for="email" class="text-md-left">{{ __('E-Mail Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label for="password" class="text-md-right">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group row justify-content-center mt-3">
                                <div class="col-auto">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label for="remember">Remember Me</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row justify-content-center mt-3">
                                <div class="col-6">
                                    <button type="submit" style="width: 100%; font-weight: lighter; background-color: #9DA27A; border-color: #9DA27A" class="btn btn-primary rounded-pill">
                                        Login
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
