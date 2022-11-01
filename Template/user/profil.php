<section class="container">
    <h2 class="text-center m-4">Profil utilisateur</h2>
    <div class="row mt-4 justify-content-center">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title"> <?= $user->mail ?> </h5>
                <h6 class="card-subtitle mb-2 text-muted">pseudo :  <?= $user->pseudo ?> </h6>
                <h6 class="card-subtitle mb-2 text-muted">Utilisateur N° <?= $user->id ?> </h6>
                <a href="/user/update/<?= $user->id ?>" class="card-link">Modifier</a>
                <a href="/user/delete/<?= $user->id ?>" class="card-link">Supprimer</a>
            </div>
        </div>
    </div>
</section>