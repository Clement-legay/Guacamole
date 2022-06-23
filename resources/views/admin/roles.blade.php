@extends('layouts.app')

@section('title', 'GuacaTube | Administration')

@section('background', 'p-4')

@section('content')
    <div class="row justify-content-between">
        <div class="col-auto">
            <h3>Roles</h3>
        </div>
        <div class="col-auto">
            <button type="button" style="display: none" id="openModal" data-bs-toggle="modal" data-bs-target="#staticBackdrop"></button>
        </div>
    </div>
    <div class="row justify-content-start">
        @foreach($roles as $role)
            <div class="col-4 p-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $role->name }}</h5>

                        <a href="#" class="btn btn-primary" onclick="openRoleMaker()">Edit</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body px-5 pt-0 pb-0">
                    <div class="row justify-content-center pt-3 pb-2">
                        <div id="role-maker" style="display: none">
                            <form method="post" action="{{ route('admin.role.create') }}">
                                @csrf
                                <div class="row form-group px-3 pt-2">
                                    <div class="col-12">
                                        <label for="role_name">Role name</label>
                                        <input type="text" placeholder="Role Name" class="form-control @error('role_name') is-invalid @enderror" id="role_name" name="role_name" value="{{ old('role_name') }}">
                                        @error('role_name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row justify-content-center pt-3">
                                    <div class="form-check col-8">
                                        <input class="form-check-input" name="canUpdate" type="checkbox" value="" id="canUpdate">
                                        <label style="font-size: 0.75em" class="form-check-label" for="canUpdate">
                                            Can Update ?
                                        </label>
                                    </div>
                                    <div class="form-check col-8">
                                        <input class="form-check-input" name="canCreate" type="checkbox" value="" id="canCreate" checked>
                                        <label style="font-size: 0.75em" class="form-check-label" for="canCreate">
                                            Can Create ?
                                        </label>
                                    </div>
                                    <div class="form-check col-8">
                                        <input class="form-check-input" type="checkbox" name="canDeleteVideo" value="" id="canDeleteVideo">
                                        <label style="font-size: 0.75em" class="form-check-label" for="canDeleteVideo">
                                            Can Delete Video ?
                                        </label>
                                    </div>
                                    <div class="form-check col-8">
                                        <input class="form-check-input" type="checkbox" name="canDeleteComment" value="" id="canDeleteComment">
                                        <label style="font-size: 0.75em" class="form-check-label" for="canDeleteComment">
                                            Can Delete Comment ?
                                        </label>
                                    </div>
                                    <div class="form-check col-8">
                                        <label style="font-size: 0.75em" class="form-check-label" for="canBanUser">
                                            Can Delete User ?
                                        </label>
                                        <input class="form-check-input" type="checkbox" name="canBanUser" value="" id="canBanUser">
                                    </div>
                                </div>
                                <div class="row justify-content-around py-3">
                                    <div class="col-auto">
                                        <button type="button" class="btn" style="border: black; background-color: black; color: white" onclick="openRoleMaker()">Close</button>
                                    </div>
                                    <div class="col-auto">
                                        <div class="row justify-content-end">
                                            <div class="col-auto">
                                                <button type="submit" class="btn" style="border: #3b6532; background-color: #3b6532 ; color: white">Create</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
