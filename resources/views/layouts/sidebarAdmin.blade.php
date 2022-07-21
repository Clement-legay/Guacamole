@extends(Agent::isMobile() ? 'layouts.sidebarAlternative' : 'layouts.sidebar')

@section('sidebar')
    <div class="row justify-content-between align-content-center p-3">
        <div onclick="doNav('{{ route('admin.users') }}')" class="col-12 profile_pages mt-3">
            <div class="row justify-content-center align-content-center">
                <div class="col-3">
                    <div class="row justify-content-center align-content-center">
                        @if(route('admin.users') == url()->current())
                            <i style="font-size: 1.5em" class="bi bi-person-fill"></i>
                        @else
                            <i style="font-size: 1.5em" class="bi bi-person"></i>
                        @endif
                    </div>
                </div>
                <div class="col-8">
                    <div class="row justify-content-start pt-1">
                        <span class="card-title link-name" style="text-transform: capitalize; font-size: 1.2em; font-weight: normal">Users</span>
                    </div>
                </div>
            </div>
        </div>
        <div onclick="doNav('{{ route('admin.videos') }}')" class="col-12 profile_pages">
            <div class="row justify-content-center align-content-center">
                <div class="col-3">
                    <div class="row justify-content-center align-content-center">
                        @if(route('admin.videos') == url()->current())
                            <i style="font-size: 1.5em" class="bi bi-play-btn-fill"></i>
                        @else
                            <i style="font-size: 1.5em" class="bi bi-play-btn"></i>
                        @endif
                    </div>
                </div>
                <div class="col-8">
                    <div class="row justify-content-start pt-1">
                        <span class="card-title link-name" style="text-transform: capitalize; font-size: 1.2em; font-weight: normal">Videos</span>
                    </div>
                </div>
            </div>
        </div>
        <div onclick="doNav('{{ route('admin.comments') }}')" class="col-12 profile_pages">
            <div class="row justify-content-center align-content-center">
                <div class="col-3">
                    <div class="row justify-content-center align-content-center">
                        @if(route('admin.comments') == url()->current())
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
        <div onclick="doNav('{{ route('admin.roles') }}')" class="col-12 profile_pages">
            <div class="row justify-content-center align-content-center">
                <div class="col-3">
                    <div class="row justify-content-center align-content-center">
                        @if(route('admin.roles') == url()->current())
                            <i style="font-size: 1.5em" class="bi bi-person-badge-fill"></i>
                        @else
                            <i style="font-size: 1.5em" class="bi bi-person-badge"></i>
                        @endif
                    </div>
                </div>
                <div class="col-8">
                    <div class="row justify-content-start pt-1">
                        <span class="card-title link-name" style="text-transform: capitalize; font-size: 1.2em; font-weight: normal">Roles</span>
                    </div>
                </div>
            </div>
        </div>
        <div onclick="doNav('{{ route('admin.token') }}')" class="col-12 profile_pages">
            <div class="row justify-content-center align-content-center">
                <div class="col-3">
                    <div class="row justify-content-center align-content-center">
                        @if(route('admin.token') == url()->current())
                            <i style="font-size: 1.5em" class="bi bi-key-fill"></i>
                        @else
                            <i style="font-size: 1.5em" class="bi bi-key"></i>
                        @endif
                    </div>
                </div>
                <div class="col-8">
                    <div class="row justify-content-start pt-1">
                        <span class="card-title link-name" style="text-transform: capitalize; font-size: 1.2em; font-weight: normal">API Key</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom-full">
            <div class="dropdown-divider"></div>
            <div onclick="doNav('{{ route('home') }}')" class="col-12 profile_pages">
                <div class="row justify-content-center align-content-center">
                    <div class="col-3">
                        <div class="row justify-content-center align-content-center">
                            <i style="font-size: 1.5em" class="bi bi-arrow-left"></i>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="row justify-content-start pt-1">
                            <span class="card-title link-name" style="text-transform: capitalize; font-size: 1.2em; font-weight: normal">Home</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
