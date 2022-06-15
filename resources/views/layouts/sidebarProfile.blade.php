<style>
    /* The sidebar menu */
    .sidebar {
        height: 100%; /* 100% Full-height */
        width: 0; /* 0 width - change this with JavaScript */
        position: fixed; /* Stay in place */
        z-index: 1; /* Stay on top */
        top: 0;
        left: 0;
        overflow-x: hidden; /* Disable horizontal scroll */
        padding-top: 60px; /* Place content 60px from the top */
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
    function doNav(url)
    {
        window.location.href = url;
    }
    /* Set the width of the sidebar to 250px and the left margin of the page content to 250px */
    function openNav() {
        if (document.getElementById("mySidebar").style.width === "250px") {
            document.getElementById("mySidebar").style.width = "125px";
            document.getElementById("sidebar").classList.remove("col-2");
            document.getElementById("sidebar").classList.add("col-1");
            document.getElementById("content").classList.remove("col-10");
            document.getElementById("content").classList.add("col-11");
            if (document.getElementById("avatar")) {
                document.getElementById("avatar").style.height = "40px";
                document.getElementById("avatar").style.width = "40px";
                document.getElementById("avatar").style.fontSize = "0.5em";
                document.getElementById("avatar-row").classList.remove("justify-content-center");
                document.getElementById("avatar-row").classList.add("justify-content-start");
            }
            let linkNames = document.getElementsByClassName("link-name")
            for (let i = 0; i < linkNames.length; i++) {
                linkNames[i].style.display = "none";
            }
        } else {
            document.getElementById("mySidebar").style.width = "250px";
            document.getElementById("sidebar").classList.remove("col-1");
            document.getElementById("sidebar").classList.add("col-2");
            document.getElementById("content").classList.remove("col-11");
            document.getElementById("content").classList.add("col-10");
            if (document.getElementById("avatar")) {
                document.getElementById("avatar").style.height = "100px";
                document.getElementById("avatar").style.width = "100px";
                document.getElementById("avatar").style.fontSize = "1.2em";
                document.getElementById("avatar-row").classList.remove("justify-content-start");
                document.getElementById("avatar-row").classList.add("justify-content-center");
                let linkNames = document.getElementsByClassName("link-name")
                for (let i = 0; i < linkNames.length; i++) {
                    linkNames[i].style.display = "flex";
                }
            } else {
                let linkNames = document.getElementsByClassName("link-name")
                for (let i = 0; i < linkNames.length; i++) {
                    linkNames[i].style.display = "unset";
                }
            }
        }
    }
</script>

<div id="mySidebar" style="width: 250px; border-right: grey 2px" class="sidebar">
    <div class="row justify-content-between align-content-center p-3">
        <div class="col-12">
            <div id="avatar-row" class="row justify-content-center align-content-center">
                <div class="col-auto">
                    <div id="avatar" style="width: 100px; height: 100px; font-size: 1.2em">
                        {!! auth()->user()->profile_image() !!}
                    </div>
                </div>
            </div>
            <div class="row justify-content-center align-content-center pt-2 link-name">
                <div class="col-auto">
                    <span style="font-size: 0.9em; font-weight: 500">Your chanel</span>
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
</div>
