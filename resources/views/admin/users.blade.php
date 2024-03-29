@extends('layouts.app')

@section('title', 'GuacaTube | Administration')

@section('background', 'p-4')

@section('content')
    <style>
        .user_row:hover {
            background-color: #f5f5f5;
            cursor: pointer;
        }
    </style>

    <script>
        function editUser(user, role) {
            console.log(role);
            let openModal = document.getElementById('openModal');
            let last_name = document.getElementById('last_name');
            let first_name = document.getElementById('first_name');
            let username = document.getElementById('username');
            let email = document.getElementById('email');


            openModal.click();
            first_name.value = user.first_name;
            last_name.value = user.last_name;
            username.value = user.username;
            email.value = user.email;
        }
    </script>

    <div class="row justify-content-center">
        <div class="col-12 col-xl-8">
{{--            <form action="{{ route('admin.users.delete') }}" method="post">--}}
{{--                @method('DELETE')--}}
{{--                @csrf--}}
{{--                <button type="submit" class="btn"><i class="bi bi-trash-fill"></i></button>--}}
{{--            </form>--}}

            <form method="get" action="{{ route('admin.users') }}">
                <div class="row justify-content-center align-content-center px-3 my-2">
                    <div class="col-6 col-lg-4">
                        <select aria-label="role" class="form-control" name="role">
                            <option value="">All Roles</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $role->id == $roleSelected ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-lg-5">
                        <input aria-label="search" type="text" class="form-control" id="searchUser" name="search" placeholder="Search a user" value="{{ $searchUser }}">
                    </div>
                    <div class="col-12 col-lg-3 mt-2 mt-lg-0">
                        <button type="submit" class="btn btn-primary w-100 text-white">Search</button>
                    </div>
                </div>
            </form>

            <table class="table">
                <thead>
                <tr>
                    <th scope="col"><input type="checkbox" id="all" class="form-check-input" aria-label="all" name="all"></th>
                    <th scope="col">User</th>
                    <th scope="col"></th>
                    <th class="d-none d-lg-table-cell" scope="col">Role</th>
                    <th class="d-none d-lg-table-cell" scope="col">Subscribers</th>
                    <th class="d-none d-lg-table-cell" scope="col">Creation Date</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr class="user_row">
                        <td><input type="checkbox" class="form-check-input userCheckbox" aria-label="all" name="{{ $user->id }}"></td>
                        <td>
                            <div style="width: 45px; height: 45px; font-size: 0.6em">
                                {!! $user->profile_image() !!}
                            </div>
                        </td>
                        <td>
                            <p class="p-0 m-0">{{ $user->first_name . ' ' . $user->last_name }}</p>
                            <p class="p-0 m-0">{{ $user->username }}</p>
                        </td>
                        <td class="d-none d-lg-table-cell">{{ $user->role()->name ?? "No attribution" }}</td>
                        <td class="d-none d-lg-table-cell">{{ $user->subscribers()->get()->count() }}</td>
                        <td class="d-none d-lg-table-cell">{{ $user->created_at->format('d F Y') }}</td>
                        <td>
                            <button onclick="doNav('{{ route('admin.user.select', $user->id64()) }}')" class="btn"><i class="bi bi-pen-fill"></i></button>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if(isset($userSelected) && $userSelected != null)

        <!-- Button trigger modal -->
        <button type="button" style="display: none" id="openModal" data-bs-toggle="modal" data-bs-target="#staticBackdrop"></button>

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body px-5 pt-0 pb-0">
                        <div class="row justify-content-center pt-3 pb-2">
                            <div class="col-auto">
                                <div id="PP-slot" style="font-size: 0.8em; width: 60px; height: 60px">
                                    {!! $userSelected->profile_image() !!}
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('admin.user.update', $userSelected->id64()) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row form-group">
                                <div class="col-6">
                                    <label for="first_name">First name</label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name') ?? $userSelected->first_name }}">
                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label for="last_name">Last name</label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name') ?? $userSelected->last_name }}">
                                    @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') ??  $userSelected->username }}">
                                    @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <label for="role">Role</label>
                                    <select type="role" class="form-control @error('role') is-invalid @enderror" id="role" name="role">
                                        <option value="" @if($userSelected->role() == null) selected @endif>No attribution</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" @if($userSelected->role() && $userSelected->role()->id == $role->id) selected @endif>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                    <div class="invalid-feedback">
                                        {{ $errors->first('role') }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') ?? $userSelected->email }}">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row justify-content-between py-3">
                                <div class="col-auto">
                                    <a type="button" class="btn" style="border: black; background-color: black; color: white" href="{{ route('admin.users') }}">Close</a>
                                </div>
                                <div class="col-auto">
                                    <div class="row justify-content-end">
                                        <div class="col-auto">
                                            <a type="button" class="btn btn-danger" href="{{ route('admin.user.delete', $userSelected->id64()) }}">Delete</a>
                                        </div>
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
            <script defer>
                document.getElementById('openModal').click();
            </script>
    @endif

    <script>
        // on checkbox click, check all checkboxes
        $('#all').click(function() {
            if ($(this).is(':checked')) {
                $('input[type="checkbox"]').prop('checked', true);
            } else {
                $('input[type="checkbox"]').prop('checked', false);
            }
        });
    </script>
@endsection
