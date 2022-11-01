<section class="container-fluid">
    <div class="row">
        <h1 class="text-center">Liste des utilisateurs</h1>
    </div>
    <div class="row justify-content-center mt-4">
        <div class="col-8">

            <ol class="list-group list-group-numbered">
                <?php foreach($users as $user) : ?>
                <a href="/user/read/<?= $user->id ?>">
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold"> <?= $user->mail ?> </div>
                        </div>
                        <span class="badge bg-primary rounded-pill"> id n° <?= $user->id ?></span>
                    </li>
                </a>
                <?php endforeach ?>
            </ol>
</section>




