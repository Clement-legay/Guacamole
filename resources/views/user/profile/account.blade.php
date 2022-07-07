@extends('layouts.app')

@section('title', 'Account')


@section('content')
    <style>
        #avatarBadge:hover:before {
            content: '+';
            position: absolute;
            background: rgb(0,0,0,0.5);
            top: 50%;
            left: 50%;
            width: 100%;
            height: 100%;
            transform: translate(-50%, -50%);
            font-size: 1.5em;
            border-radius: 50%;
            color: white;
            cursor: pointer;
        }

        #avatarBadge {
            position: relative;

        }

    </style>

    <form action="{{ route('profile.update', auth()->user()->id()) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="row justify-content-between py-3">
                    <div class="col-auto">
                        <h3 class="mb-3">Contenu de la chaîne</h3>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary text-white">Update</button>
                    </div>
                </div>

                <div class="row d-flex justify-content-center align-items-center">
                    @if(auth()->user()->profile_image)
                        <div class="col-auto mb-3">
                            <img src="{{ asset(auth()->user()->profile_image) }}" alt="avatar" class="img-fluid rounded-circle" style="width: 100px; height: 100px;">
                        </div>
                    @else
                        <div class="col-auto mb-3">
                            <input id="color" value="{{ auth()->user()->color }}" style="background: {{ auth()->user()->color }}" type="color" onchange="changeColor(this.value)" class="form-control @error('color') is-invalid @enderror" name="color" required autofocus>
                        </div>
                        <div class="col-auto mb-3">
                            <div style="width: 100px; height: 100px; font-size: 1.35em">
                                {!! auth()->user()->profile_image() !!}
                            </div>
                        </div>
                    @endif
                </div>

                <div class="row form-group">
                    <div class="col-6">
                        <label for="first_name">First name</label>
                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name') ?? auth()->user()->first_name }}">
                        @error('first_name')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="last_name">Last name</label>
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name') ?? auth()->user()->last_name }}">
                        @error('last_name')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="username">Username</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') ??  auth()->user()->username }}">
                        @error('username')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                </div>
                <div class="row justify-content-between py-3">
                    <div class="col-auto">
                        <div class="row justify-content-end">
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary text-white">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
