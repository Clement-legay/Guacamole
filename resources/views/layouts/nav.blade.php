<style>
    .search-input {
        width: 100%;
    }
    @media screen and (max-width: 450px) {
        .btn-search {

        }
    }

    @media screen and (min-width: 450px) {
        .btn-search {
            padding: .45rem 1.5rem .35rem;
        }
    }
</style>

<script>
    document.querySelectorAll('.dropdown-toggle').forEach(item => {
        item.addEventListener('click', event => {
            if(event.target.classList.contains('dropdown-toggle') ){
                event.target.classList.toggle('toggle-change');
            }
            else if(event.target.parentElement.classList.contains('dropdown-toggle')){
                event.target.parentElement.classList.toggle('toggle-change');
            }
        })
    });
</script>

<!-- Navbar -->
<nav class="navbar-light bg-white fixed-top pt-2 px-3" style="width: 100%; height: 60px; z-index: 1">
    <div class="flex-row d-flex justify-content-between">
        <div class="flex-column col-lg-1 col-sm-2">
            <div class="flex-row d-flex justify-content-between align-content-center">
                <div class="flex-column col-lg-auto col-sm-6">
                    <button class="btn" onclick="openNav()">
                        <div class="navbar-toggler-icon"></div>
                    </button>
                </div>
                <div class="flex-column col-lg-1 col-sm-6">
                    <a class="navbar-brand" href="{{ route('home') }}">
                        @if(Agent::isMobile())
                            <img style="width: 40px; height: 40px" src="{{ asset('img/logo2.png') }}" alt="logo">
                        @else
                            <img style="width: 105px; height: 40px" src="{{ asset('img/logoTextDark.png') }}" alt="logo">
                        @endif
                    </a>
                </div>
            </div>
        </div>
        <div class="flex-column col-lg-5 col-sm-4">
            <form class="input-group search-input" action="{{ route('search') }}" method="get">
                <input type="search" value="@yield('search')" name="search" class="form-control" placeholder="Search" aria-label="Search" />
                <button class="btn btn-outline-success btn-search" type="submit" data-mdb-ripple-color="dark">
                    Search
                </button>
            </form>
        </div>
        <div class="flex-column col-lg-1 col-sm-2">
            <div class="flex-row d-flex justify-content-between align-content-center">
                <div class="flex-column col-lg-auto col-sm-6">
{{--                    <button class="btn">--}}
{{--                        <i style="font-size: 1.2em" class="bi bi-bell-fill"></i>--}}
{{--                    </button>--}}
                    <a href="{{ route('profile.upload') }}" class="btn">
                        <i style="font-size: 1.2em" class="bi bi-upload"></i>
                    </a>
                </div>
                <div class="flex-column col-lg-auto col-sm-6">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 profile-menu">
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="flex-row d-flex p-0 m-0">
                                    <div class="flex-column col-auto p-0 m-0">
                                        @guest
                                            <i style="font-size: 1.2em" class="bi bi-person-fill"></i>
                                        @endguest
                                        @auth
                                            <div style="width: 35px; height: 35px; font-size: 0.50em">
                                                {!! auth()->user()->profile_image() !!}
                                            </div>
                                        @endauth
                                    </div>
                                    <div class="flex-column col-auto p-0 m-0">
                                        <i style="font-size: 0.8em" class="bi bi-caret-down-fill ps-2"></i>
                                    </div>
                                </div>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @guest
                                    <li><a class="dropdown-item" href="{{route('register')}}"><i class="fas fa-sliders-h fa-fw"></i> Sign in</a></li>
                                    <li><a class="dropdown-item" href="{{route('login')}}"><i class="fas fa-cog fa-fw"></i> Login</a></li>
                                @endguest
                                @auth
                                    <li><a class="dropdown-item" href="{{route('profile.content') }}"><i class="fas fa-user fa-fw"></i> Profile</a></li>
                                    <li><a class="dropdown-item" href="{{route('logout')}}"><i class="fas fa-sign-out-alt fa-fw"></i> Log Out</a></li>
                                @endauth
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Container wrapper -->
</nav>
<!-- Navbar -->
