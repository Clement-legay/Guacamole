@extends('layouts.app')

@section('title', 'Account')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/styleAccountUpdate.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js" integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
@endsection

@section('background', '')

@section('content')
    <style>
        #avatarForm:hover:before {
            content: '';
            position: absolute;
            background: rgb(0,0,0,0.5);
            top: 50%;
            left: 50%;
            width: 100%;
            height: 100%;
            transform: translate(-50%, -50%);
            border-radius: 50%;
            cursor: pointer;
        }

        #avatarForm:hover:after {
            content: '+';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 1.8em;
            color: white;
        }

        #avatarForm {
            position: relative;
        }
    </style>

    <script>
        $('#color').on('change', function() {
            $('#color').css('background-color', $(this).val());

        });

        function changeColor(color) {
            document.getElementById("avatarBadge").style.background = color
            document.getElementById("color").style.background = color
        }

        function changeAvatar() {
            let lastnameLetter = document.getElementById("last_name").value.charAt(0).toUpperCase()
            let firstnameLetter = document.getElementById("first_name").value.charAt(0).toUpperCase()
            document.getElementById("avatarBadge").innerText = firstnameLetter + lastnameLetter
        }
    </script>

    <form action="{{ route('profile.update', auth()->user()->id64()) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row justify-content-center p-0 m-0">
            <div class="col-10 col-lg-10">
                <div class="row justify-content-between py-3">
                    <div class="col-auto">
                        <h3 class="mb-3">Account</h3>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary text-white">Update</button>
                    </div>
                </div>
                <div class="row d-flex justify-content-center align-items-center">
                    @if(auth()->user()->profile_image)
                        <div class="col-2 col-lg-1 mb-3">
                            <a class="btn" href="{{ route('profile.updateAvatarDelete', auth()->user()->id64()) }}"><i class="bi bi-trash3-fill"></i></a>
                        </div>
                    @else
                        <div class="col-2 col-lg-1 mb-3">
                            <input aria-label="color" id="color" value="{{ auth()->user()->color }}" style="background: {{ auth()->user()->color }}" type="color" class="form-control @error('color') is-invalid @enderror" name="color" required autofocus>
                        </div>
                    @endif
                    <div class="col-auto mb-3">
                        <div id="avatarForm" onclick="PP.click()" style="width: 100px; height: 100px; font-size: 1.35em" class="@error('thumbnail_cropped') is-invalid @enderror">
                            {!! auth()->user()->profile_image('avatarUpdate') !!}
                        </div>
                        <input type="hidden" id="url-avatar" value="{{ route('user.API_user_update_avatar', Auth::user()->id64()) }}">
                        <input type="file" style="display: none" id="PP" name="PP" accept="image/gif, image/jpeg, image/png">
                        <input type="hidden" id="PP_cropped" name="profile_image" value="">
                        <div class="modal fade" id="modalPP" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body px-0">
                                        <div class="row justify-content-center px-0">
                                            <div class="col-11 px-0">
                                                <img style="max-height: 500px" id="image-PP" src="#" alt="tre">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" id="cancelModalPP">Cancel</button>
                                        <button type="button" class="btn btn-primary" id="cropPP">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 col-lg-1 mb-3">
                    </div>
                </div>
                <div class="col-2 col-lg-1 mb-3">
                </div>


                <div class="row form-group">
                    <div class="col-6">
                        <label for="first_name">First name</label>
                        <input type="text" oninput="changeAvatar()" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name') ?? auth()->user()->first_name }}">
                        @error('first_name')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label for="last_name">Last name</label>
                        <input type="text" oninput="changeAvatar()" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name') ?? auth()->user()->last_name }}">
                        @error('last_name')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label for="username">Username</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') ??  auth()->user()->username }}">
                        @error('username')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="col-12 mb-3 my-3">
                        <div class="card bg-light">
                            <div class="card-body pb-0">
                                <div class="row justify-content-center">
                                    <div class="col-12">
                                        <div class="row justify-content-center">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="banner" id="bannerOpener" class="btn btn-file"><i class="bi bi-upload"></i> Upload a banner</label>
                                                    <input type="file" style="display: none" class=" @error('banner_cropped') is-invalid @enderror" id="banner" name="banner" accept="image/gif, image/jpeg, image/png">
                                                    <input type="hidden" name="banner_cropped" id="banner_cropped">
                                                    @error('banner_cropped')
                                                        <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>


                                                <div class="modal fade" id="modalBanner" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-body px-0">
                                                                <div class="row justify-content-center px-0">
                                                                    <div class="col-11 px-0">
                                                                        <img style="max-height: 500px" id="image-banner" src="#" alt="tre">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" id="cancelModalBanner">Cancel</button>
                                                                <button type="button" class="btn btn-primary" id="cropBanner">Crop</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 my-3">
                                                <img src="{{ Auth::user()->banner_image ? asset(Auth::user()->banner_image) : 'https://via.placeholder.com/1920x325?text=16:3' }}" id="banner-picture" alt="Banner" style="width: 100%; aspect-ratio: 16 / 3">
                                            </div>
                                            @if(Auth::user()->banner_image)
                                                <div class="col-12 my-3">
                                                    <div class="row justify-content-end">
                                                        <div class="col-auto">
                                                            <a href="{{ route('profile.updateBannerDelete', auth()->user()->id64()) }}" class="btn btn-danger" id="deleteBanner">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-end py-3">
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

    <script src="{{ asset('js/scriptAccountUpdate.js') }}"></script>
@endsection
