@extends(Agent::isMobile() ? 'layouts.sidebarAlternative' : 'layouts.sidebar')

@section('sidebar')
    <div class="row justify-content-between align-content-center p-3">
        <div class="col-12">
            <div id="avatar-row" class="row justify-content-center align-content-center">
                <div class="col-auto">
                    <a style="text-decoration: none" href="{{ route('channel', auth()->user()->id()) }}">
                        <div id="avatar" style="width: 100px; height: 100px; font-size: 1.2em">
                            {!! auth()->user()->profile_image() !!}
                        </div>
                    </a>
                </div>
            </div>
            <div class="row justify-content-center align-content-center pt-2 link-name">
                <div class="col-auto">
                    <a style="text-decoration: none; color: black" href="{{ route('channel', auth()->user()->id()) }}">
                        <span style="font-size: 0.9em; font-weight: 500">Your chanel</span>
                    </a>
                </div>
            </div>
            <div class="row justify-content-center align-content-center link-name">
                <div class="col-auto">
                    <span style="font-size: 0.68em; font-weight: 400">{{ auth()->user()->username }}</span>
                </div>
            </div>
        </div>

        <div onclick="doNav('{{ route('profile.dashboard') }}')" class="col-12 profile_pages mt-3">
            <div class="row justify-content-center align-content-center">
                <div class="col-3">
                    <div class="row justify-content-center align-content-center">
                        @if(route('profile.dashboard') == url()->current())
                            <i style="font-size: 1.5em" class="bi bi-menu-app-fill"></i>
                        @else
                            <i style="font-size: 1.5em" class="bi bi-menu-app"></i>
                        @endif
                    </div>
                </div>
                <div class="col-8">
                    <div class="row justify-content-start pt-1">
                        <span class="card-title link-name" style="text-transform: capitalize; font-size: 1.2em; font-weight: normal">Dashboard</span>
                    </div>
                </div>
            </div>
        </div>
        <div onclick="doNav('{{ route('profile.content') }}')" class="col-12 profile_pages">
            <div class="row justify-content-center align-content-center">
                <div class="col-3">
                    <div class="row justify-content-center align-content-center">
                        @if(route('profile.content') == url()->current())
                            <i style="font-size: 1.5em" class="bi bi-play-btn-fill"></i>
                        @else
                            <i style="font-size: 1.5em" class="bi bi-play-btn"></i>
                        @endif
                    </div>
                </div>
                <div class="col-8">
                    <div class="row justify-content-start pt-1">
                        <span class="card-title link-name" style="text-transform: capitalize; font-size: 1.2em; font-weight: normal">Content</span>
                    </div>
                </div>
            </div>
        </div>
        <div onclick="doNav('{{ route('profile.comments') }}')" class="col-12 profile_pages">
            <div class="row justify-content-center align-content-center">
                <div class="col-3">
                    <div class="row justify-content-center align-content-center">
                        @if(route('profile.comments') == url()->current())
                            <i style="font-size: 1.5em" class="bi bi-chat-left-dots-fill"></i>
                        @else
                            <i style="font-size: 1.5em" class="bi bi-chat-left-dots"></i>
                        @endif
                    </div>
                </div>
                <div class="col-8">
                    <div class="row justify-content-start pt-1">
                        <span class="card-title link-name" style="text-transform: capitalize; font-size: 1.2em; font-weight: normal">Comments</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom-full">
            <div class="dropdown-divider"></div>
            <div onclick="doNav('{{ route('profile.parameters') }}')" class="col-12 profile_pages">
                <div class="row justify-content-center align-content-center">
                    <div class="col-3">
                        <div class="row justify-content-center align-content-center">
                            @if(route('profile.parameters') == url()->current())
                                <i style="font-size: 1.5em" class="bi bi-gear-fill"></i>
                            @else
                                <i style="font-size: 1.5em" class="bi bi-gear"></i>
                            @endif
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="row justify-content-start pt-1">
                            <span class="card-title link-name" style="text-transform: capitalize; font-size: 1.2em; font-weight: normal">Parameters</span>
                        </div>
                    </div>
                </div>
            </div>
            <div onclick="doNav('{{ route('profile.account') }}')" class="col-12 profile_pages">
                <div class="row justify-content-center align-content-center">
                    <div class="col-3">
                        <div class="row justify-content-center align-content-center">
                            @if(route('profile.account') == url()->current())
                                <i style="font-size: 1.5em" class="bi bi-person-fill"></i>
                            @else
                                <i style="font-size: 1.5em" class="bi bi-person"></i>
                            @endif
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="row justify-content-start pt-1">
                            <span class="card-title link-name" style="text-transform: capitalize; font-size: 1.2em; font-weight: normal">Account</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
