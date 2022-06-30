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

            let linkNames = document.getElementsByClassName("link-name")
            for (let i = 0; i < linkNames.length; i++) {
                linkNames[i].style.display = "unset";

            }
        }
    }
</script>

<div id="mySidebar" style="width: 250px; border-right: grey 2px" class="sidebar">
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
</div>
