<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande de Prêt</title>
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
        .col-md-6 {
            flex: 0 0 auto;
            width: 50%;
        }
    </style>
    <script>
        function validateForm() {
            const montant = document.forms["pretForm"]["montant"].value;
            if (montant <= 0) {
                alert("Le montant du prêt doit être un nombre positif.");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <?php include('navbar.php'); ?>
    <div class="container mt-5">
        <div class="card card-custom">
            <div class="row g-0">
                <!-- Réduction de la colonne d'informations à 6/12 pour laisser plus d'espace à l'image -->
                <div class="col-md-6">
                    <div class="card-body">
                        <h1 class="card-title">Demande de Prêt</h1>
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>
                        <?php if (session()->getFlashdata('message')): ?>
                            <div class="alert alert-success">
                                <?= session()->getFlashdata('message') ?>
                            </div>
                        <?php endif; ?>
                        <form name="pretForm" action="/client/demanderPret" method="post" onsubmit="return validateForm()">
                            <div class="mb-3">
                                <label for="montant" class="form-label">Montant du prêt</label>
                                <input type="number" class="form-control" name="montant" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Demander Prêt</button>
                        </form>
                    </div>
                </div>
                <!-- Augmenter la largeur de la colonne de l'image à 6/12 -->
                <div class="col-md-6">
                    <img src="<?php echo base_url('assets/images/pret.gif'); ?>" class="img-fluid image-gif" alt="Prêt GIF">
                </div>
            </div>
        </div>
    </div>
</body>
</html>
