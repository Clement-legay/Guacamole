
<div class="container">
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
        <p class="col-md-4 mb-0 text-muted">&copy; 2021 Company, Inc</p>

        <a href="/"
           class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
            <svg class="bi me-2" width="40" height="32">
                <use xlink:href="#bootstrap"/>
            </svg>
        </a>

        <ul class="nav col-md-4 justify-content-end">
            <li class="nav-item"><a href="{{route('products.index')}} " class="nav-link px-2 text-muted">Home</a></li>
            <li class="nav-item"><a href="{{route('home')}}" class="nav-link px-2 text-muted">Derniers produits</a></li>
            <li class="nav-item"><a href="{{route('login')}}" class="nav-link px-2 text-muted">Connexion</a></li>
            <li class="nav-item"><a href="{{route('register')}}" class="nav-link px-2 text-muted">S'enregistrer</a></li>
            <!--            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">FAQs</a></li>-->
            <!--            <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">About</a></li>-->
        </ul>
    </footer>
</div>
