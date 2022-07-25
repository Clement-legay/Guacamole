<style>
    /* The sidebar menu */
    .sidebar {
        height: 100%; /* 100% Full-height */
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

    @media screen and (min-width: 1921px) {
        .sidebar {
            width: 8.33%; /* 250px width - change this with JavaScript */
        }
    }

    @media screen and (max-width: 1921px) {
        .sidebar {
            width: 16.7%; /* 250px width - change this with JavaScript */
        }
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
    // function openNav() {
    //     if (document.getElementById("mySidebar").style.width === "250px") {
    //         document.getElementById("mySidebar").style.width = "125px";
    //         document.getElementById("sidebar").classList.remove("col-2");
    //         document.getElementById("sidebar").classList.add("col-1");
    //         document.getElementById("content").classList.remove("col-10");
    //         document.getElementById("content").classList.add("col-11");
    //
    //         let linkNames = document.getElementsByClassName("link-name")
    //         for (let i = 0; i < linkNames.length; i++) {
    //             linkNames[i].style.display = "none";
    //         }
    //     } else {
    //         document.getElementById("mySidebar").style.width = "250px";
    //         document.getElementById("sidebar").classList.remove("col-1");
    //         document.getElementById("sidebar").classList.add("col-2");
    //         document.getElementById("content").classList.remove("col-11");
    //         document.getElementById("content").classList.add("col-10");
    //
    //         let linkNames = document.getElementsByClassName("link-name")
    //         for (let i = 0; i < linkNames.length; i++) {
    //             linkNames[i].style.display = "unset";
    //
    //         }
    //     }
    // }

    function openNav() {
        if (document.getElementById("mySidebar").style.width === "5%") {
            document.getElementById("mySidebar").style.width = "16.7%";
            document.getElementById("containerGlobal").style.paddingLeft = "16.7%";
            if (document.getElementById("avatar")) {
                document.getElementById("avatar").style.height = "100px";
                document.getElementById("avatar").style.width = "100px";
                document.getElementById("avatar").style.fontSize = "1.2em";
                document.getElementById("avatar-row").classList.remove("justify-content-start");
                document.getElementById("avatar-row").classList.add("justify-content-center");
                let linkNames = document.getElementsByClassName("link-name")
                for (let i = 0; i < linkNames.length; i++) {
                    linkNames[i].style.display = null;
                }
            } else {
                let linkNames = document.getElementsByClassName("link-name")
                for (let i = 0; i < linkNames.length; i++) {
                    linkNames[i].style.display = null;
                }
            }
        } else {
            document.getElementById("mySidebar").style.width = "5%";
            document.getElementById("containerGlobal").style.paddingLeft = "5%";
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
        }
    }
</script>

<div id="mySidebar" class="sidebar">
    @yield('sidebar')
</div>
