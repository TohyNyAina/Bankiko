<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <style>
        .card-custom {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            min-height: 120px; /* Réduire la hauteur minimale des cartes */
            padding: 10px; /* Réduire le remplissage pour diminuer la hauteur globale */
        }
        .card-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }
        .card-container .card {
            flex: 1 1 30%;
            margin: 10px;
        }
        .card-title {
            font-size: 1.5em; /* Taille du texte du titre */
            font-weight: bold; /* Texte en gras */
        }
        .card-text {
            font-size: 1.2em; /* Taille du texte du corps */
            font-weight: bold; /* Texte en gras */
        }
        .text-green {
            color: green; /* Couleur verte pour l'argent déposé */
        }
        .text-yellow-orange {
            color: #FFA500; /* Couleur jaune-orange pour l'argent retiré */
        }
        .image-card {
            text-align: center; /* Centrer le contenu */
            padding: 20px;
            min-height: 100px; /* Hauteur ajustée pour la carte de l'image */
        }
        .image-card img {
            max-width: 100%; /* Ajuster l'image à la carte */
            height: auto; /* Maintenir les proportions de l'image */
        }
    </style>
</head>
<body>
    <?php include('navbar.php'); ?>
    <div class="container mt-5">
        <h1>Tableau de bord</h1>
        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('message') ?>
            </div>
        <?php endif; ?>

         <!-- Cartes de statistiques -->
         <div class="card-container">
            <div class="card card-custom">
                <div class="card-body">
                    <h5 class="card-title">Nombre Total de Clients</h5>
                    <p class="card-text"><?= $totalClients ?></p>
                </div>
            </div>
            <div class="card card-custom">
                <div class="card-body">
                    <h5 class="card-title">Total des Argents Déposés</h5>
                    <p class="card-text text-green"><?= number_format($totalDepots, 2) ?> MGA</p>
                </div>
            </div>
            <div class="card card-custom">
                <div class="card-body">
                    <h5 class="card-title">Total des Argents Retirés</h5>
                    <p class="card-text text-yellow-orange"><?= number_format($totalRetraits, 2) ?> MGA</p>
                </div>
            </div>
        </div>

        <!-- Carte pour l'image GIF -->
        <div class="card card-custom image-card">
            <div class="card-body">
                <img src="<?php echo base_url('assets/images/dashboard.gif'); ?>" alt="Animation Admin Dashboard">
            </div>
        </div>

    </div>
</body>
</html>
