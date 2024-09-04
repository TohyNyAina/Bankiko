<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <style>
        .card-custom {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .image-gif {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
    <h1 class="text-center mb-4">Bienvenue sur BANKIKO</h1>
    <br>
        <div class="card card-custom">
            <div class="row g-0">
                <div class="col-md-6">
                    <div class="card-body">
                        <h1 class="text-center mb-4">Connexion</h1>
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>
                        <form action="/loginUser" method="post">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Entrer votre email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" class="form-control" name="password" placeholder="Entrer votre mot de passe" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Se connecter</button>
                            <a href="/register" class="btn btn-link">J' ai pas de compte</a>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <img src="<?php echo base_url('assets/images/login.gif'); ?>" class="img-fluid image-gif" alt="Login GIF">
                </div>
            </div>
        </div>
    </div>
</body>
</html>
