<style>
    @keyframes slide {
        100% {
            left: 0;
        }
    }

    @keyframes slideBack {
        0% {
            left: 0;
        }
        100% {
            left: -250px;
        }
    }

    /* The sidebar menu */
    .sidebar {
        height: 100%; /* 100% Full-height */
        width: 0; /* 0 width - change this with JavaScript */
        position: fixed; /* Stay in place */
        z-index: 1051; /* Stay on top */
        background: white;
        top: 0;
        left: 0;
        overflow-x: hidden; /* Disable horizontal scroll */
        }

    /* On smaller screens, where height is less than 450px, change the style of the sidenav (less padding and a smaller font size) */
    @media screen and (max-height: 450px) {
        .sidebar {padding-top: 15px;}
        .sidebar a {font-size: 18px;}
    }

    .profile_pages:hover {
        background-color: #f5f5f5;
        cursor: pointer;
    }

    .bottom-full {
        position: absolute;
        bottom: 0;
    }
</style>

<script>
    let hidden = true;

    function doNav(url)
    {
        window.location.href = url;
    }

    function openNav() {
        if (hidden) {
            document.getElementById("mySidebar").style.animation = "slide 0.5s forwards";
            document.getElementById("darkener").classList.add("show");
            document.getElementById("darkener").style.display = "flex";
            hidden = false;
        } else {
            document.getElementById("mySidebar").style.animation = "slideBack 0.5s forwards";
            document.getElementById("darkener").classList.remove("show");
            document.getElementById("darkener").style.display = "none";
            hidden = true;
        }
    }
</script>

<div id="darkener" class="modal-backdrop fade" onclick="openNav()" style="display: none"></div>
<div id="mySidebar" style="width: 250px; left: -250px" class="sidebar">
    <div class="row justify-content-around align-content-center">
        <div class="col-auto">
            <button class="btn" onclick="openNav()">
                <i class="bi bi-list" style="font-size: 1.5em; text-align: center"></i>
            </button>
        </div>
        <div class="col-auto pt-1 pe-4">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img style="width: 105px; height: 40px" src="{{ asset('img/logoTextDark.png') }}" alt="logo">
            </a>
        </div>
        </div>
    @yield('sidebar')
</div>
