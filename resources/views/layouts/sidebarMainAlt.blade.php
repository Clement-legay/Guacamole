@extends('layouts.sidebarAlternative')

@section('sidebar')
    <div class="row justify-content-between align-content-center p-3">
        <div onclick="doNav('{{ route('home') }}')" class="col-12 profile_pages">
            <div class="row justify-content-center align-content-center">
                <div class="col-3">
                    <div class="row justify-content-center align-content-center">
                        @if(route('home') == url()->current())
                            <i style="font-size: 1.5em" class="bi bi-house-fill"></i>
                        @else
                            <i style="font-size: 1.5em" class="bi bi-house"></i>
                        @endif
                    </div>
                </div>
                <div class="col-8">
                    <div class="row justify-content-start pt-1">
                        <span class="card-title link-name" style="text-transform: capitalize; font-size: 1.2em; font-weight: normal">Home</span>
                    </div>
                </div>
            </div>
        </div>
        <div onclick="doNav('{{ route('explore') }}')" class="col-12 profile_pages">
            <div class="row justify-content-center align-content-center">
                <div class="col-3">
                    <div class="row justify-content-center align-content-center">
                        @if(route('explore') == url()->current())
                            <i style="font-size: 1.5em" class="bi bi-compass-fill"></i>
                        @else
                            <i style="font-size: 1.5em" class="bi bi-compass"></i>
                        @endif
                    </div>
                </div>
                <div class="col-8">
                    <div class="row justify-content-start pt-1">
                        <span class="card-title link-name" style="text-transform: capitalize; font-size: 1.2em; font-weight: normal">Explore</span>
                    </div>
                </div>
            </div>
        </div>
        <div onclick="doNav('{{ route('likedVideos') }}')" class="col-12 profile_pages">
            <div class="row justify-content-center align-content-center">
                <div class="col-3">
                    <div class="row justify-content-center align-content-center">
                        @if(route('likedVideos') == url()->current())
                            <i style="font-size: 1.5em" class="bi bi-hand-thumbs-up-fill"></i>
                        @else
                            <i style="font-size: 1.5em" class="bi bi-hand-thumbs-up"></i>
                        @endif
                    </div>
                </div>
                <div class="col-8">
                    <div class="row justify-content-start pt-1">
                        <span class="card-title link-name" style="text-transform: capitalize; font-size: 1.2em; font-weight: normal">Liked Videos</span>
                    </div>
                </div>
            </div>
        </div>
        <div onclick="doNav('{{ route('history') }}')" class="col-12 profile_pages">
            <div class="row justify-content-center align-content-center">
                <div class="col-3">
                    <div class="row justify-content-center align-content-center">
                        @if(route('history') == url()->current())
                            <i style="font-size: 1.5em" class="bi bi-clock-fill"></i>
                        @else
                            <i style="font-size: 1.5em" class="bi bi-clock-history"></i>
                        @endif
                    </div>
                </div>
                <div class="col-8">
                    <div class="row justify-content-start pt-1">
                        <span class="card-title link-name" style="text-transform: capitalize; font-size: 1.2em; font-weight: normal">History</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
