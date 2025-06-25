<header class="main-header bg-white shadow-sm py-3">
  <div class="container d-flex align-items-center justify-content-between position-relative">

    <!-- Logo -->
    <a href="{{ route('index') }}" class="navbar-brand m-0 p-0">
      <img src="{{ asset('images/logo.webp') }}" alt="Logo" class="logo-img">
    </a>

    <!-- Auth buttons for tablet only -->
    <div class="auth-buttons-tablet d-none d-sm-flex d-lg-none gap-2">
      <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#registerModal">S'inscrire</button>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Se connecter</button>
    </div>

    <!-- Navigation Desktop -->
    <nav class="d-none d-lg-flex">
      <ul class="nav gap-3">
        <li class="nav-item dropdown dropdown-hover">
          <a class="nav-link dropdown-toggle {{ Route::is('index') ? 'active' : '' }}" href="#" id="accueilDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Accueil
          </a>
          <ul class="dropdown-menu" aria-labelledby="accueilDropdown">
            <li><a class="dropdown-item" href="{{ route('index') }}">Accueil</a></li>
            <li><a class="dropdown-item" href="{{ route('index', ['section' => 'categories']) }}">Catégories</a></li>
            <li><a class="dropdown-item" href="{{ route('index', ['section' => 'annonces']) }}">Annonces à la une</a></li>
            <li><a class="dropdown-item" href="{{ route('index', ['section' => 'chiffres']) }}">Chiffres clés</a></li>
            <li><a class="dropdown-item" href="{{ route('index', ['section' => 'blog']) }}">Blog</a></li>
            <li><a class="dropdown-item" href="{{ route('index', ['section' => 'newsletter']) }}">Newsletter</a></li>
          </ul>
        </li>
        <li class="nav-item"><a class="nav-link {{ Route::is('jobs') ? 'active' : '' }}" href="{{ route('jobs') }}">Trouver un job</a></li>
        <li class="nav-item"><a class="nav-link {{ Route::is('recruiters') ? 'active' : '' }}" href="{{ route('recruiters') }}">Entreprises partenaires</a></li>
        <li class="nav-item dropdown dropdown-hover">
          <a class="nav-link dropdown-toggle {{ Route::is('about', 'prices', 'blog') ? 'active' : '' }}" href="#" id="pagesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Pages
          </a>
          <ul class="dropdown-menu" aria-labelledby="pagesDropdown">
            <li><a class="dropdown-item" href="{{ route('about') }}">Qui sommes-nous</a></li>
            <li><a class="dropdown-item" href="{{ route('prices') }}">Nos prix</a></li>
            <li><a class="dropdown-item" href="{{ route('blog') }}">Blog</a></li>
          </ul>
        </li>
      </ul>
    </nav>

    <!-- Auth buttons Desktop -->
    <div class="d-none d-lg-flex gap-2">
      @auth
        @if(Auth::user()->role === 'recruiter')
          <a href="{{ route('dashboard.recruiter') }}" class="btn btn-primary">Tableau de bord</a>
        @elseif(Auth::user()->role === 'candidate')
          <a href="{{ route('dashboard.candidate') }}" class="btn btn-primary">Tableau de bord</a>
        @endif
      @else
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#registerModal">S'inscrire</button>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Se connecter</button>
      @endauth
    </div>

    <!-- Burger icon for tablet/mobile -->
    <button class="d-sm-block d-lg-none btn btn-light border burger-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu">
      <i class="fas fa-bars fs-4"></i>
    </button>
  </div>

  <!-- Mobile/Tablet Menu -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="mobileMenu">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title">Menu</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column gap-3">
      <a href="{{ route('jobs') }}" class="{{ Route::is('jobs') ? 'active' : '' }}">Trouver un job</a>
      <a href="{{ route('recruiters') }}" class="{{ Route::is('recruiters') ? 'active' : '' }}">Entreprises partenaires</a>
      <a href="{{ route('about') }}" class="{{ Route::is('about') ? 'active' : '' }}">Qui sommes-nous</a>
      <a href="{{ route('prices') }}" class="{{ Route::is('prices') ? 'active' : '' }}">Nos prix</a>
      <a href="{{ route('blog') }}" class="{{ Route::is('blog') ? 'active' : '' }}">Blog</a>
      <a href="#categories">Catégories</a>
      <a href="#annonces">Annonces à la une</a>
      <a href="#chiffres">Chiffres clés</a>
      <a href="#newsletter">Newsletter</a>
      <hr>
      @auth
        @if(Auth::user()->role === 'recruiter')
          <a href="{{ route('dashboard.recruiter') }}" class="btn btn-primary w-100">Tableau de bord</a>
        @elseif(Auth::user()->role === 'candidate')
          <a href="{{ route('dashboard.candidate') }}" class="btn btn-primary w-100">Tableau de bord</a>
        @endif
      @else
        <button class="btn btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#registerModal">S'inscrire</button>
        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#loginModal">Se connecter</button>
      @endauth
    </div>
  </div>
</header>

@include('components.auth.modals.login')
@include('components.auth.modals.register')