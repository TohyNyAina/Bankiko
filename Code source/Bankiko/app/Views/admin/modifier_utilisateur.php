<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Utilisateur</title>
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
</head>
<body>
    <?php include('navbar.php'); ?>
    <div class="container mt-5">
        <h1 class="mb-4">Modifier Utilisateur</h1>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

       
        <div class="card shadow">
            <div class="card-body">
                <form action="/admin/modifierUtilisateur/<?= $utilisateur['id'] ?>" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Nom d'utilisateur</label>
                        <input type="text" class="form-control" name="username" value="<?= $utilisateur['username'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <input type="number" class="form-control" name="telephone" value="<?= $utilisateur['telephone'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="<?= $utilisateur['email'] ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Modifier</button>
                    <a href="/admin/gestionUtilisateurs" class="btn btn-secondary">Annuler</a>
                </form>
            </div>
        </div>
       

    </div>
</body>
</html>
