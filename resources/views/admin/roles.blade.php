@extends('layouts.app')

@section('title', 'GuacaTube | Administration')

@section('background', 'p-4')

@section('content')
    <div class="row justify-content-between">
        <div class="col-auto">
            <h3>Roles</h3>
        </div>
        <div class="col-auto">
            @can('create', App\Role::class)
                <a class="btn btn-primary" style="color: white" href="{{ route('admin.role.create') }}">Create</a>
            @endcan
        </div>
        <div class="col-12">
            @if(count($errors) > 0)
                @foreach($errors->all() as $error)
                    <span style="color: #7a0d0d">{{ $error }}</span>
                @endforeach
            @endif
        </div>
    </div>
    <div class="row justify-content-start">
        @can('view', App\Role::class)
            @foreach($roles as $role)
                <div class="col-lg-4 col-12 p-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-between mb-3">
                                <div class="col-auto">
                                    <h5 class="card-title mb-0">{{ $role->name }}</h5>
                                    <span style="font-size: 0.75em; color: {{ $role->isAdmin ? 'red' : 'black' }}">{{ $role->isAdmin ? 'Admin' : 'Not admin' }}</span>
                                </div>
                                <div class="col-auto">
                                    @if(Auth()->user()->role()->canDeleteRole)
                                        <a href="{{ route('admin.role.delete', $role->id64()) }}" style="color: red" class="btn" onclick="doNav('{{ route('admin.role.delete', $role->id64()) }}')">Delete</a>
                                    @endif
                                    @if(Auth()->user()->role()->canUpdateRole)
                                        <a href="{{ route('admin.role.select', $role->id64()) }}" class="btn" onclick="doNav('{{ route('admin.role.select', $role->id64()) }}')">Edit</a>
                                    @endif
                                </div>
                            </div>
                            <div class="row justify-content-between">
                                <div class="col-6">
                                    <p class="card-text p-0 m-0">Video level</p>
                                    <p class="card-text p-0 m-0" style="color: {{ $role->levelVideo()['color'] }}; font-weight: 450; font-size: 0.8em">{{ $role->levelVideo()['text'] }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="card-text p-0 m-0">User level</p>
                                    <p class="card-text p-0 m-0" style="color: {{ $role->levelUser()['color'] }}; font-weight: 450; font-size: 0.8em">{{ $role->levelUser()['text'] }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="card-text p-0 m-0">Role level</p>
                                    <p class="card-text p-0 m-0" style="color: {{ $role->levelRole()['color'] }}; font-weight: 450; font-size: 0.8em">{{ $role->levelRole()['text'] }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="card-text p-0 m-0">Comments level</p>
                                    <p class="card-text p-0 m-0" style="color: {{ $role->levelComment()['color'] }}; font-weight: 450; font-size: 0.8em">{{ $role->levelComment()['text'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12">
                <p>You don't have permission to view content on this page.</p>
            </div>
        @endcan
    </div>

    @if(isset($roleSelected) && $roleSelected != null)
        <button type="button" style="display: none" id="openModal" data-bs-toggle="modal" data-bs-target="#staticBackdrop"></button>

        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body px-5 pt-0 pb-0">
                        <div class="row justify-content-center pt-3 pb-2">
                            <div id="role-maker">
                                <form method="post" action="{{ route('admin.role.update', $roleSelected->id64()) }}">
                                    @method('PUT')
                                    @csrf
                                    <div class="flex-row d-flex align-items-center justify-content-center form-group">
                                        <div class="col-4 me-3">
                                            <label for="name">Role name</label>
                                            <input type="text" placeholder="Role Name" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $roleSelected->name  }}">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-check col-4 ms-5 pt-4">
                                            <input class="form-check-input" name="isAdmin" {{ $roleSelected->isAdmin ? 'checked' : ''  }} type="checkbox" id="isAdmin">
                                            <label style="font-size: 0.9em; color: red" class="form-check-label" for="isAdmin">
                                                Is Admin ?
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center pt-3">
                                        <div class="col-6">
                                            <div class="row justify-content-center">
                                                <div class="col-9">
                                                    <p class="p-0 m-0 my-1">Videos</p>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canWatchVideos" type="checkbox" {{ $roleSelected->canWatchVideos ? 'checked' : ''  }} id="canWatchVideos">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canWatchVideos">
                                                        Can watch ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canCreateVideo" type="checkbox" {{ $roleSelected->canCreateVideo ? 'checked' : ''  }} id="canCreateVideo">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canCreateVideo">
                                                        Can create ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canUpdateVideo" type="checkbox" {{ $roleSelected->canUpdateVideo ? 'checked' : ''  }} id="canUpdateVideo">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdateVideo">
                                                        Can Update ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canDeleteVideo" type="checkbox" {{ $roleSelected->canDeleteVideo ? 'checked' : ''  }} id="canDeleteVideo">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canDeleteVideo">
                                                        Can delete ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canUpdateOthersVideo" type="checkbox" {{ $roleSelected->canUpdateOthersVideo ? 'checked' : ''  }} id="canUpdateOthersVideo">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdateOthersVideo">
                                                        Can update others ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canDeleteOthersVideo" type="checkbox" {{ $roleSelected->canDeleteOthersVideo ? 'checked' : ''  }} id="canDeleteOthersVideo">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canDeleteOthersVideo">
                                                        Can delete others ?
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row justify-content-center">
                                                <div class="col-9">
                                                    <p class="p-0 m-0 my-1">Users</p>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canUpdateUserSelf" type="checkbox" {{ $roleSelected->canUpdateUserSelf ? 'checked' : ''  }} id="canUpdateUserSelf">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdateUserSelf">
                                                        Can update self ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canDeleteUserSelf" type="checkbox" {{ $roleSelected->canDeleteUserSelf ? 'checked' : ''  }} id="canDeleteUserSelf">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canDeleteUserSelf">
                                                        Can delete self ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canViewUser" type="checkbox" {{ $roleSelected->canViewUser ? 'checked' : ''  }} id="canViewUser">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canViewUser">
                                                        Can view ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canCreateUser" type="checkbox" {{ $roleSelected->canCreateUser ? 'checked' : ''  }} id="canCreateUser">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canCreateUser">
                                                        Can create ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canUpdateUserOther" type="checkbox" {{ $roleSelected->canUpdateUserOther ? 'checked' : ''  }} id="canUpdateUserOther">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdateUserOther">
                                                        Can update others ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canDeleteUserOther" type="checkbox" {{ $roleSelected->canDeleteUserOther ? 'checked' : ''  }} id="canDeleteUserOther">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canDeleteUserOther">
                                                        Can delete others ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canUpdateUserRole" type="checkbox" {{ $roleSelected->canUpdateUserRole ? 'checked' : ''  }} id="canUpdateUserRole">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdateUserRole">
                                                        Can update role ?
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row justify-content-center">
                                                <div class="col-9">
                                                    <p class="p-0 m-0 my-1">Comments</p>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canViewComments" type="checkbox" {{ $roleSelected->canViewComments ? 'checked' : ''  }} id="canViewComments">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canViewComments">
                                                        Can view ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canCreateComment" type="checkbox" {{ $roleSelected->canCreateComment ? 'checked' : ''  }} id="canCreateComment">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canCreateComment">
                                                        Can create ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canUpdateCommentSelf" type="checkbox" {{ $roleSelected->canUpdateCommentSelf ? 'checked' : ''  }} id="canUpdateCommentSelf">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdateCommentSelf">
                                                        Can update self ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canUpdateCommentOther" type="checkbox" {{ $roleSelected->canUpdateCommentOther ? 'checked' : ''  }} id="canUpdateCommentOther">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdateCommentOther">
                                                        Can update others ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canDeleteCommentSelf" type="checkbox" {{ $roleSelected->canDeleteCommentSelf ? 'checked' : ''  }} id="canDeleteCommentSelf">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canDeleteCommentSelf">
                                                        Can delete self ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canDeleteCommentOther" type="checkbox" {{ $roleSelected->canDeleteCommentOther ? 'checked' : ''  }} id="canDeleteCommentOther">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canDeleteCommentOther">
                                                        Can delete others ?
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row justify-content-center">
                                                <div class="col-9">
                                                    <p class="p-0 m-0 my-1">Roles</p>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canViewRoles" type="checkbox" {{ $roleSelected->canViewRoles ? 'checked' : ''  }} id="canViewRoles">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canViewRoles">
                                                        Can view ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canCreateRole" type="checkbox" {{ $roleSelected->canCreateRole ? 'checked' : ''  }} id="canCreateRole">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canCreateRole">
                                                        Can create ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canUpdateRole" type="checkbox" {{ $roleSelected->canUpdateRole ? 'checked' : ''  }} id="canUpdateRole">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdateRole">
                                                        Can update ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canDeleteRole" type="checkbox" {{ $roleSelected->canDeleteRole ? 'checked' : ''  }} id="canDeleteRole">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canDeleteRole">
                                                        Can delete ?
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
                                                    <button type="submit" class="btn" style="border: #3b6532; background-color: #3b6532 ; color: white">Update</button>
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

    @if(route('admin.role.create') == url()->current())
        <button type="button" style="display: none" id="openCreateModal" data-bs-toggle="modal" data-bs-target="#createRole"></button>

        <div class="modal fade" id="createRole" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createRoleLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body px-5 pt-0 pb-0">
                        <div class="row justify-content-center pt-3 pb-2">
                            <div id="role-maker">
                                <form method="post" action="{{ route('admin.role.create') }}">
                                    @csrf
                                    <div class="flex-row d-flex align-items-center justify-content-center form-group">
                                        <div class="col-4 me-3">
                                            <label for="name">Role name</label>
                                            <input type="text" placeholder="Role Name" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name')  }}">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>
                                        <div class="form-check col-4 ms-5 pt-4">
                                            <input class="form-check-input" name="isAdmin" type="checkbox" id="isAdmin">
                                            <label style="font-size: 0.9em; color: red" class="form-check-label" for="isAdmin">
                                                Is Admin ?
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center pt-3">
                                        <div class="col-6">
                                            <div class="row justify-content-center">
                                                <div class="col-9">
                                                    <p class="p-0 m-0 my-1">Videos</p>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canWatchVideos" type="checkbox" id="canWatchVideos">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canWatchVideos">
                                                        Can watch ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canCreateVideo" type="checkbox" id="canCreateVideo">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canCreateVideo">
                                                        Can create ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canUpdateVideo" type="checkbox" id="canUpdateVideo">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdateVideo">
                                                        Can Update ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canDeleteVideo" type="checkbox" id="canDeleteVideo">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canDeleteVideo">
                                                        Can delete ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canUpdateOthersVideo" type="checkbox" id="canUpdateOthersVideo">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdateOthersVideo">
                                                        Can update others ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canDeleteOthersVideo" type="checkbox" id="canDeleteOthersVideo">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canDeleteOthersVideo">
                                                        Can delete others ?
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row justify-content-center">
                                                <div class="col-9">
                                                    <p class="p-0 m-0 my-1">Users</p>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canUpdateUserSelf" type="checkbox" id="canUpdateUserSelf">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdateUserSelf">
                                                        Can update self ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canDeleteUserSelf" type="checkbox" id="canDeleteUserSelf">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canDeleteUserSelf">
                                                        Can delete self ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canViewUser" type="checkbox" id="canViewUser">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canViewUser">
                                                        Can view ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canCreateUser" type="checkbox" id="canCreateUser">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canCreateUser">
                                                        Can create ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canUpdateUserOther" type="checkbox" id="canUpdateUserOther">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdateUserOther">
                                                        Can update others ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canDeleteUserOther" type="checkbox" id="canDeleteUserOther">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canDeleteUserOther">
                                                        Can delete others ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canUpdateUserRole" type="checkbox" id="canUpdateUserRole">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdateUserRole">
                                                        Can update role ?
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row justify-content-center">
                                                <div class="col-9">
                                                    <p class="p-0 m-0 my-1">Comments</p>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canViewComments" type="checkbox" id="canViewComments">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canViewComments">
                                                        Can view ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canCreateComment" type="checkbox" id="canCreateComment">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canCreateComment">
                                                        Can create ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canUpdateCommentSelf" type="checkbox" id="canUpdateCommentSelf">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdateCommentSelf">
                                                        Can update self ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canUpdateCommentOther" type="checkbox" id="canUpdateCommentOther">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdateCommentOther">
                                                        Can update others ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canDeleteCommentSelf" type="checkbox" id="canDeleteCommentSelf">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canDeleteCommentSelf">
                                                        Can delete self ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canDeleteCommentOther" type="checkbox" id="canDeleteCommentOther">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canDeleteCommentOther">
                                                        Can delete others ?
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row justify-content-center">
                                                <div class="col-9">
                                                    <p class="p-0 m-0 my-1">Roles</p>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canViewRoles" type="checkbox" id="canViewRoles">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canViewRoles">
                                                        Can view ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canCreateRole" type="checkbox" id="canCreateRole">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canCreateRole">
                                                        Can create ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canUpdateRole" type="checkbox" id="canUpdateRole">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canUpdateRole">
                                                        Can update ?
                                                    </label>
                                                </div>
                                                <div class="form-check col-9">
                                                    <input class="form-check-input" name="canDeleteRole" type="checkbox" id="canDeleteRole">
                                                    <label style="font-size: 0.75em" class="form-check-label" for="canDeleteRole">
                                                        Can delete ?
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
            document.getElementById('openCreateModal').click();
        </script>
    @endif
@endsection
