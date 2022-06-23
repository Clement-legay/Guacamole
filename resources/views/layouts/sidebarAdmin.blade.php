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
</div>
