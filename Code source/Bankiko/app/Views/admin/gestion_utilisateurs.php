<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs</title>
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <style>
        .card-custom {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php include('navbar.php'); ?>
    <div class="container mt-5">
        <h1>Gestion des Utilisateurs</h1>
        <br>
        <div class="card card-custom">
            <div class="card-body">
                <?php if (session()->getFlashdata('message')): ?>
                    <div class="alert alert-success">
                        <?= session()->getFlashdata('message') ?>
                    </div>
                <?php endif; ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom d'utilisateur</th>
                            <th>Téléphone</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($utilisateurs as $utilisateur): ?>
                            <tr>
                                <td><?= $utilisateur['id'] ?></td>
                                <td><?= $utilisateur['username'] ?></td>
                                <td><?= $utilisateur['telephone'] ?></td>
                                <td><?= $utilisateur['email'] ?></td>
                                <td><?= $utilisateur['role'] ?></td>
                                <td>
                                    <!-- N'affichez les boutons Modifier et Supprimer que si le rôle n'est pas 'admin' -->
                                    <?php if ($utilisateur['role'] !== 'admin'): ?>
                                        <a href="/admin/modifierUtilisateur/<?= $utilisateur['id'] ?>" class="btn btn-warning">Modifier</a>
                                        <a href="/admin/supprimerUtilisateur/<?= $utilisateur['id'] ?>" class="btn btn-danger">Supprimer</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
