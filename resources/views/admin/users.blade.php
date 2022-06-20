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

    <h3>Users</h3>


    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">User</th>
            <th scope="col"></th>
            <th scope="col">Role</th>
            <th scope="col">Creation Date</th>
            <th scope="col">Subscribers</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr onclick="doNav('{{ null }}')" class="user_row">
                <th scope="row">{{ $user->id }}</th>
                <td>
                    <div style="width: 45px; height: 45px; font-size: 0.6em">
                        {!! $user->profile_image() !!}
                    </div>
                </td>
                <td>
                    <p class="p-0 m-0">{{ $user->first_name . ' ' . $user->last_name }}</p>
                    <p class="p-0 m-0">{{ $user->username }}</p>
                </td>
                <td>{{ $user->role()->first()->name ?? "No attribution" }}</td>
                <td>{{ $user->subscribers()->get()->count() }}</td>
                <td>{{ $user->created_at->format('d F Y') }}</td>
                <td>
                    <a href="#" class="btn"><i class="bi bi-pen-fill"></i></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
