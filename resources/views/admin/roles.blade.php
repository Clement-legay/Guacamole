@extends('layouts.app')

@section('title', 'GuacaTube | Administration')

@section('background', 'p-4')

@section('content')
    <div class="row justify-content-between">
        <div class="col-auto">
            <h3>Roles</h3>
        </div>
    </div>
    <div class="row justify-content-start">
        @foreach($roles as $role)
            <div class="col-4 p-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $role->name }}</h5>

                        <a href="{{ route('admin.role.select', $role->id64()) }}" class="btn btn-primary" onclick="doNav('{{ route('admin.role.select', $role->id64()) }}')">Edit</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if(isset($roleSelected) && $roleSelected != null)
        <button type="button" style="display: none" id="openModal" data-bs-toggle="modal" data-bs-target="#staticBackdrop"></button>

        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body px-5 pt-0 pb-0">
                        <div class="row justify-content-center pt-3 pb-2">
                            <div id="role-maker">
                                <form method="post" action="{{ route('admin.role.create') }}">
                                    @csrf
                                    <div class="flex-row d-flex align-items-center justify-content-center form-group">
                                        <div class="col-4 me-3">
                                            <label for="role_name">Role name</label>
                                            <input type="text" placeholder="Role Name" class="form-control @error('role_name') is-invalid @enderror" id="role_name" name="role_name" value="{{ old('role_name') }}">
                                            @error('role_name')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-check col-4 ms-5 pt-4">
                                            <input class="form-check-input" name="canUpdate" type="checkbox" value="{{ $roleSelected }}" id="canUpdate">
                                            <label style="font-size: 0.9em; color: red" class="form-check-label" for="canUpdate">
                                                Is Admin ?
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center pt-3">
                                        <div class="col-6">
                                            <div class="row justify-content-center">
                                                <div class="col-7">
                                                    <p class="p-0 m-0 my-1">Videos</p>
                                                </div>
                                                <div class="form-check col-7">
                                                    <input class="form-check-input" name="canUpdate" type="checkbox" value="{{ $roleSelected }}" id="canUpdate">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdate">
                                                        Can Update ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-7">
                                                    <input class="form-check-input" name="canUpdate" type="checkbox" value="{{ $roleSelected }}" id="canUpdate">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdate">
                                                        Can Update ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-7">
                                                    <input class="form-check-input" name="canUpdate" type="checkbox" value="{{ $roleSelected }}" id="canUpdate">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdate">
                                                        Can Update ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-7">
                                                    <input class="form-check-input" name="canUpdate" type="checkbox" value="{{ $roleSelected }}" id="canUpdate">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdate">
                                                        Can Update ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-7">
                                                    <input class="form-check-input" name="canUpdate" type="checkbox" value="{{ $roleSelected }}" id="canUpdate">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdate">
                                                        Can Update ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-7">
                                                    <input class="form-check-input" name="canUpdate" type="checkbox" value="{{ $roleSelected }}" id="canUpdate">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdate">
                                                        Can Update ?
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row justify-content-center">
                                                <div class="col-7">
                                                    <p class="p-0 m-0 my-1">Users</p>
                                                </div>
                                                <div class="form-check col-7">
                                                    <input class="form-check-input" name="canUpdate" type="checkbox" value="{{ $roleSelected }}" id="canUpdate">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdate">
                                                        Can Update ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-7">
                                                    <input class="form-check-input" name="canUpdate" type="checkbox" value="{{ $roleSelected }}" id="canUpdate">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdate">
                                                        Can Update ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-7">
                                                    <input class="form-check-input" name="canUpdate" type="checkbox" value="{{ $roleSelected }}" id="canUpdate">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdate">
                                                        Can Update ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-7">
                                                    <input class="form-check-input" name="canUpdate" type="checkbox" value="{{ $roleSelected }}" id="canUpdate">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdate">
                                                        Can Update ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-7">
                                                    <input class="form-check-input" name="canUpdate" type="checkbox" value="{{ $roleSelected }}" id="canUpdate">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdate">
                                                        Can Update ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-7">
                                                    <input class="form-check-input" name="canUpdate" type="checkbox" value="{{ $roleSelected }}" id="canUpdate">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdate">
                                                        Can Update ?
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row justify-content-center">
                                                <div class="col-7">
                                                    <p class="p-0 m-0 my-1">Comments</p>
                                                </div>
                                                <div class="form-check col-7">
                                                    <input class="form-check-input" name="canUpdate" type="checkbox" value="{{ $roleSelected }}" id="canUpdate">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdate">
                                                        Can Update ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-7">
                                                    <input class="form-check-input" name="canUpdate" type="checkbox" value="{{ $roleSelected }}" id="canUpdate">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdate">
                                                        Can Update ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-7">
                                                    <input class="form-check-input" name="canUpdate" type="checkbox" value="{{ $roleSelected }}" id="canUpdate">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdate">
                                                        Can Update ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-7">
                                                    <input class="form-check-input" name="canUpdate" type="checkbox" value="{{ $roleSelected }}" id="canUpdate">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdate">
                                                        Can Update ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-7">
                                                    <input class="form-check-input" name="canUpdate" type="checkbox" value="{{ $roleSelected }}" id="canUpdate">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdate">
                                                        Can Update ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-7">
                                                    <input class="form-check-input" name="canUpdate" type="checkbox" value="{{ $roleSelected }}" id="canUpdate">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdate">
                                                        Can Update ?
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row justify-content-center">
                                                <div class="col-7">
                                                    <p class="p-0 m-0 my-1">Roles</p>
                                                </div>
                                                <div class="form-check col-7">
                                                    <input class="form-check-input" name="canUpdate" type="checkbox" value="{{ $roleSelected }}" id="canUpdate">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdate">
                                                        Can Update ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-7">
                                                    <input class="form-check-input" name="canUpdate" type="checkbox" value="{{ $roleSelected }}" id="canUpdate">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdate">
                                                        Can Update ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-7">
                                                    <input class="form-check-input" name="canUpdate" type="checkbox" value="{{ $roleSelected }}" id="canUpdate">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdate">
                                                        Can Update ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-7">
                                                    <input class="form-check-input" name="canUpdate" type="checkbox" value="{{ $roleSelected }}" id="canUpdate">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdate">
                                                        Can Update ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-7">
                                                    <input class="form-check-input" name="canUpdate" type="checkbox" value="{{ $roleSelected }}" id="canUpdate">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdate">
                                                        Can Update ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-7">
                                                    <input class="form-check-input" name="canUpdate" type="checkbox" value="{{ $roleSelected }}" id="canUpdate">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdate">
                                                        Can Update ?
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-around py-3">
                                        <div class="col-auto">
                                            <a type="button" class="btn" style="border: black; background-color: black; color: white" href="{{ route('admin.roles') }}">Close</a>
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
        <script defer>
            document.getElementById('openModal').click();
        </script>
    @endif
@endsection
