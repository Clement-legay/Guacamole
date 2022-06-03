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
<nav class="navbar-light bg-white fixed-top pt-2 px-3" style="width: 100%; height: 60px; align-items: center">
        <div class="row justify-content-between">
            <div class="col-auto">
                <div class="row justify-content-between align-content-center">
                    <div class="col-auto">
                        <button class="btn" onclick="openNav()">
                            <div class="navbar-toggler-icon"></div>
                        </button>
                    </div>
                    <div class="col-auto">
                        <a class="navbar-brand" href="{{ route('home') }}">
                            <img style="width: 40px; height: 40px" src="{{ asset('img/logo2.png') }}" alt="logo">
                            Guacatube
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-auto">
                <form class="input-group" action="{{ route('search') }}" method="post" style="width: 400px">
                    @csrf
                    <input type="search" value="@yield('search')" name="search" class="form-control" placeholder="Search" aria-label="Search" />
                    <button class="btn btn-outline-primary" type="submit" data-mdb-ripple-color="dark" style="padding: .45rem 1.5rem .35rem;">
                        Search
                    </button>
                </form>
            </div>
            <div class="col-auto">
                <div class="row justify-content-between align-content-center">
                    <div class="col-auto">
                        <button class="btn">
                            <i class="bi bi-bell-fill"></i>
                        </button>
                    </div>
                    <div class="col-auto">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 profile-menu">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-fill"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    @guest
                                        <li><a class="dropdown-item" href="{{route('register')}}"><i class="fas fa-sliders-h fa-fw"></i> Sign in</a></li>
                                        <li><a class="dropdown-item" href="{{route('login')}}"><i class="fas fa-cog fa-fw"></i> Login</a></li>
                                    @endguest
                                    @auth
                                        <li><a class="dropdown-item" href="{{route('logout')}}"><i class="fas fa-sign-out-alt fa-fw"></i> Log Out</a></li>
                                    @endauth
                                </ul>
                            </li>
                        </ul>
                    </div>


                </div>
            </div>
                <!-- Toggle button -->


                <!-- Collapsible wrapper -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left links -->
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active d-flex flex-column text-center" aria-current="page" href="{{route('home')}}"><i class="fas fa-home fa-lg"></i><span class="small">Home</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex flex-column text-center" aria-current="page" href=""><i class="fas fa-home fa-lg"></i><span class="small">Tous les Articles</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex flex-column text-center" aria-current="page" href=""><i class="fas fa-user-friends fa-lg"></i><span class="small">Créer un Produit</span></a>
                        </li>

                    </ul>
                    <!-- Left links -->
                </div>

        </div>
        <!-- Collapsible wrapper -->
    <!-- Container wrapper -->
</nav>
<!-- Navbar -->
