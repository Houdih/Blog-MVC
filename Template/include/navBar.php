<nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <div class="collapse justify-content-center navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/">Acceuil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/user">Liste utilisateur</a>
        </li>
      </ul>
    </div>
    <div>
      <uL class="navbar-nav">
        <?php if(isset($_SESSION['user']) && $_SESSION['user']->getId()): ?>
          <li class="nav-item">
            <a class="nav-link" href="/user/profil/<?php echo $_SESSION['user']->getId() ?>">Profil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/user/logout">Déconnexion</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="/user/login">Connexion</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/user/create">Inscription</a>
          </li>
        <?php endif; ?>
      </uL>
    </div>
  </div>
</nav>