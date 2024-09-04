<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard</title>
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <style>
        /* Styles supplémentaires pour améliorer l'apparence du tableau de bord */
        .dashboard-info {
            font-weight: bold;
            font-size: 1.2em;
        }
        .solde-positif {
            color: green;
        }
        .montant-negatif {
            color: red;
        }
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
    <?php include('navbar.php'); ?>
    <div class="container mt-5">
        <h1>Bonjour, <?= session()->get('username') ?></h1>

        <div class="card card-custom">
            <div class="row g-0">
                <!-- Colonne pour les informations -->
                <div class="col-md-8">
                    <div class="card-body">
                        <p class="dashboard-info">Votre ID : <?= session()->get('id') ?></p>

                        <?php if (isset($compte) && isset($compte['id'])): ?>
                            <p class="dashboard-info">Numéro de compte : <?= $compte['id'] ?></p>
                        <?php else: ?>
                            <p class="dashboard-info">Numéro de compte : Non disponible</p>
                        <?php endif; ?>

                        <?php if (isset($compte) && isset($compte['solde'])): ?>
                            <p class="dashboard-info solde-positif">Solde actuel : <?= number_format($compte['solde'], 2) ?> MGA</p>
                        <?php else: ?>
                            <p class="dashboard-info solde-positif">Solde actuel : 0,00 MGA</p>
                        <?php endif; ?>

                        <?php
                            // Afficher le montant restant du prêt
                            $pretModel = new \App\Models\PretModel();
                            $pretActif = $pretModel->where('compte_id', $compte['id'])->where('montant >', 0)->first();
                            $resteARembourser = $pretActif ? $pretActif['montant'] : 0;
                        ?>
                        <p class="dashboard-info montant-negatif">Montant restant à rembourser : <?= number_format($resteARembourser, 2) ?> MGA</p>
                    </div>
                </div>

                <!-- Colonne pour l'image GIF -->
                <div class="col-md-4">
                    <img src="<?php echo base_url('assets/images/dashboard.gif'); ?>" class="img-fluid image-gif" alt="Dashboard GIF">
                </div>
            </div>
        </div>

        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert alert-success mt-3">
                <?= session()->getFlashdata('message') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger mt-3">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
