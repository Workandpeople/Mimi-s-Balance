<footer class="footer bg-light text-black pt-5 pb-4">
  <div class="container">
    <div class="row gy-4">

      {{-- Colonne 1 : Logo + intro + réseaux --}}
      <div class="col-md-4">
        <a href="{{ route('index') }}" class="d-inline-block mb-3">
          <img src="{{ asset('images/logo.webp') }}" alt="Logo" style="height: 40px;">
        </a>
        <p class="small text-muted">
          WorkEasy est le cœur de la communauté design et la meilleure ressource pour découvrir et se connecter à des designers et des offres d’emploi dans le monde entier.
        </p>
        <div class="d-flex gap-3 mt-3">
          <a href="#" class="text-black"><i class="fab fa-facebook fa-lg"></i></a>
          <a href="#" class="text-black"><i class="fab fa-twitter fa-lg"></i></a>
          <a href="#" class="text-black"><i class="fab fa-instagram fa-lg"></i></a>
          <a href="#" class="text-black"><i class="fab fa-linkedin fa-lg"></i></a>
        </div>
      </div>

      {{-- Colonne 2 : Pages --}}
      <div class="col-md-2">
        <h6 class="text-uppercase fw-bold mb-3">Pages</h6>
        <ul class="list-unstyled small">
          <li><a href="{{ route('jobs') }}" class="text-black text-decoration-none">Trouver un job</a></li>
          <li><a href="{{ route('recruiters') }}" class="text-black text-decoration-none">Entreprises</a></li>
          <li><a href="{{ route('blog') }}" class="text-black text-decoration-none">Blog</a></li>
          <li><a href="{{ route('about') }}" class="text-black text-decoration-none">À propos</a></li>
          <li><a href="{{ route('prices') }}" class="text-black text-decoration-none">Nos prix</a></li>
        </ul>
      </div>

      {{-- Colonne 3 : App mobile --}}
      <div class="col-md-3">
        <h6 class="text-uppercase fw-bold mb-3">Application mobile</h6>
        <button class="btn btn-outline-dark btn-sm w-100 mb-2" disabled>
          <i class="fab fa-apple me-2"></i> iOS - Coming Soon
        </button>
        <button class="btn btn-outline-dark btn-sm w-100" disabled>
          <i class="fab fa-android me-2"></i> Android - Coming Soon
        </button>
      </div>

      {{-- Colonne 4 : Mentions légales --}}
      <div class="col-md-3">
        <h6 class="text-uppercase fw-bold mb-3">À propos</h6>
        <ul class="list-unstyled small">
            <li>
            <a href="#" class="text-black text-decoration-none" data-bs-toggle="modal" data-bs-target="#cguModal">CGU</a>
            </li>
            <li>
            <a href="#" class="text-black text-decoration-none" data-bs-toggle="modal" data-bs-target="#privacyModal">Politique de confidentialité</a>
            </li>

            <!-- CGU Modal -->
            <div class="modal fade" id="cguModal" tabindex="-1" aria-labelledby="cguModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="cguModalLabel">Conditions Générales d'Utilisation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <p>Contenu des CGU...</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
              </div>
              </div>
            </div>
            </div>

            <!-- Privacy Policy Modal -->
            <div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="privacyModalLabel">Politique de Confidentialité</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <p>Contenu de la politique de confidentialité...</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
              </div>
              </div>
            </div>
            </div>
            <li class="mt-3 text-muted">Créé par <strong><a href="https://lucs-dinnichert.fr" class="text-black text-decoration-none">Lucas Dinnichert</a></strong></li>
            <li class="text-muted">Designé par <strong><a href="https://lucs-dinnichert.fr" class="text-black text-decoration-none">Lucas Dinnichert</a></strong></li>
        </ul>
      </div>

    </div>

    {{-- Bas de page --}}
    <div class="text-center text-muted small mt-5">
      © {{ date('Y') }} WorkEasy. Tous droits réservés.
    </div>
  </div>
</footer>