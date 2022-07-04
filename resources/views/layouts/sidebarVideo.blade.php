@extends(Agent::isMobile() ? 'layouts.sidebarAlternative' : 'layouts.sidebar')

@section('sidebar')
    <div class="row justify-content-between align-content-center p-3">
        <div class="col-12">
            <div onclick="doNav('{{ route('profile.content') }}')" class="row justify-content-center align-content-center profile_pages">
                <div class="col-3">
                    <div class="row justify-content-center align-content-center">
                        <i style="font-size: 1.5em" class="bi bi-arrow-left"></i>
                    </div>
                </div>
                <div class="col-8">
                    <div class="row justify-content-start pt-1">
                        <span class="card-title link-name" style="text-transform: capitalize; font-size: 1.2em; font-weight: normal">Your chanel</span>
                    </div>
                </div>
            </div>
            @if((url()->current() == route('video.create')) == false)
                <div id="avatar-row" class="row justify-content-center align-content-center">
                    <a href="{{route('watch', $video->id())}}">
                        <img src="{{ asset($video->thumbnail) }}" alt="{{ $video->title }}" width="100%">
                    </a>
                </div>
                <div class="row justify-content-center align-content-start pt-2 link-name">
                    <div class="col-auto">
                        <a style="text-decoration: none; color: black" href="{{route('watch', $video->id())}}">
                            <span style="font-size: 0.9em; font-weight: 500">Your video</span>
                        </a>
                    </div>
                </div>
                <div class="row justify-content-center align-content-center link-name">
                    <div class="col-auto">
                        <span style="font-size: 0.68em; font-weight: 400">{{ $video->title }}</span>
                    </div>
                </div>
            @else
                <div class="row justify-content-center align-content-start pt-2 link-name">
                    <div class="col-auto">
                        <span style="font-size: 0.9em; font-weight: 500">Create your video</span>
                    </div>
                </div>
            @endif
        </div>

        @if((url()->current() == route('video.create')) == false)
        <div onclick="doNav('{{ route('video.details', base64_encode($video->id)) }}')" class="col-12 profile_pages mt-3">
        @else
        <div class="col-12 mt-3 disabled">
        @endif
            <div class="row justify-content-center align-content-center">
                <div class="col-3">
                    <div class="row justify-content-center align-content-center">
                        @if((url()->current() == route('video.create')) == false && route('video.details', base64_encode($video->id)) == url()->current())
                            <i style="font-size: 1.5em" class="bi bi-pen-fill"></i>
                        @else
                            <i style="font-size: 1.5em" class="bi bi-pen"></i>
                        @endif
                    </div>
                </div>
                <div class="col-8">
                    <div class="row justify-content-start pt-1">
                        <span class="card-title link-name" style="text-transform: capitalize; font-size: 1.2em; font-weight: normal">Details</span>
                    </div>
                </div>
            </div>
        </div>
        @if((url()->current() == route('video.create')) == false)
        <div onclick="doNav('{{ route('video.dashboard', base64_encode($video->id)) }}')" class="col-12 profile_pages mt-3">
        @else
        <div class="col-12 mt-3 disabled">
        @endif
            <div class="row justify-content-center align-content-center">
                <div class="col-3">
                    <div class="row justify-content-center align-content-center">
                        @if((url()->current() == route('video.create')) == false && route('video.dashboard', base64_encode($video->id)) == url()->current())
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

        @if((url()->current() == route('video.create')) == false)
        <div onclick="doNav('{{ route('video.comments', base64_encode($video->id)) }}')" class="col-12 profile_pages mt-3">
        @else
        <div class="col-12 mt-3 disabled">
        @endif
            <div class="row justify-content-center align-content-center">
                <div class="col-3">
                    <div class="row justify-content-center align-content-center">
                        @if((url()->current() == route('video.create')) == false && route('video.comments', base64_encode($video->id)) == url()->current())
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
