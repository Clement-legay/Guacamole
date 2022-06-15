@extends('Auth.appLogin')

@section('title', 'Register')

@section('content')
    <script>
        let state = false
        function swapForm() {
            let x = document.getElementById("stepOne");
            let y = document.getElementById("stepTwo");
            if (state) {
                x.style.animation = "slideBack 0.5s forwards";
                y.style.animation = "slideBack2 0.5s forwards";
                state = false
            } else {
                x.style.animation = "slide 0.5s forwards";
                y.style.animation = "slide2 0.5s forwards";
                state = true
            }
        }

        // changing color on id avatar input
        function changeColor(color) {
            document.getElementById("avatar").style.background = color
        }

        function changeAvatar() {
            let lastnameLetter = document.getElementById("last_name").value.charAt(0).toUpperCase()
            let firstnameLetter = document.getElementById("first_name").value.charAt(0).toUpperCase()
            let avatar = firstnameLetter + lastnameLetter
            console.log(avatar)
            document.getElementById("avatar").innerText = avatar


        }
    </script>
    <style>

        @keyframes slide2 {
            100% {
                left: 200px;
                opacity: 100%;
            }
        }
        @keyframes slide {
            100% {
                left: -200px;
                opacity: 0;
            }
        }
        @keyframes slideBack2 {
            100% {
                right: 200px;
                opacity: 0;
            }
        }
        @keyframes slideBack {
            100% {
                right: -200px;
                opacity: 100%;
            }
        }
        #stepOne {
            position: absolute;
            left: 50%;
            height: 100px;
            top: 50%; /* à 50%/50% du parent référent */
            transform: translate(-50%, -50%); /* décalage de 50% de sa propre taille */
            width: 70%
        }
        #stepTwo {
            position: absolute;
            left: 150%;
            height: 100px;
            top: 50%; /* à 50%/50% du parent référent */
            transform: translate(-50%, -50%); /* décalage de 50% de sa propre taille */
            width: 70%;
            opacity: 0;
        }
        #registerCard {
            height: 450px;
        }
    </style>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div id="registerCard" class="card p-4 rounded">
                    <div class="row justify-content-around">
                        <div class="col-auto">
                            <a href="{{route('login')}}" class="modal-title text-black-50" style="font-size: 2em; text-decoration: none">Login</a>
                        </div>
                        <div class="col-auto">
                            <h1 style="text-decoration: underline #9DA27A">Register</h1>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group row justify-content-center align-content-center">
                                <div class="col-5">
                                    <label for="color" class="text-md-left">Avatar Color</label>
                                    <input id="color" value="{{ old('color') ?? '#9DA27A' }}" type="color" onchange="changeColor(this.value)" class="form-control @error('color') is-invalid @enderror" name="color" required autofocus>
                                </div>
                                <div class="col-5">
                                    <div class="row justify-content-center align-content-center">
                                        <div class="col-auto">
                                            <div id="avatar" style="border-radius: 50%; background-color: {{ old('color') ?? '#9DA27A' }}; text-transform: uppercase; color: white; width: 70px; height: 70px; padding-top: 17%; text-align: center; font-size: 2em">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="stepOne">
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

                                <div class="form-group">
                                    <label for="password-confirm" class="text-md-right">{{ __('Confirm Password') }}</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                                <div class="form-group row justify-content-center mt-3">
                                    <div class="col-6">
                                        <button type="button" onclick="swapForm()" style="width: 100%; font-weight: lighter; background-color: #9DA27A; border-color: #9DA27A" class="btn btn-primary rounded-pill">
                                            Next
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div id="stepTwo">

                                <div class="form-group">
                                    <label for="first_name" class="text-md-left">Firstname</label>
                                    <input id="first_name" onchange="changeAvatar()" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autofocus>

                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="last_name" class="text-md-left">Lastname</label>
                                    <input id="last_name" onchange="changeAvatar()" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autofocus>

                                    @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form_group">
                                    <label for="username" class="text-md-left">Username</label>
                                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autofocus>
                                </div>


                                <div class="form-group row justify-content-center mt-3">
                                    <div class="col-auto">
                                        <button type="button" onclick="swapForm()" style="width: 100%; font-weight: lighter; background-color: #9DA27A; border-color: #9DA27A" class="btn btn-primary rounded-pill">
                                            Back
                                        </button>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" style="width: 100%; font-weight: lighter; background-color: #9DA27A; border-color: #9DA27A" class="btn btn-primary rounded-pill">
                                            Register
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
