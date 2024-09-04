<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faire un Retrait</title>
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
        }
    </style>
    <script>
        function validateForm() {
            const montant = document.forms["retraitForm"]["montant"].value;
            if (montant <= 0) {
                alert("Le montant du retrait doit être un nombre positif.");
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
                <div class="col-md-8">
                    <div class="card-body">
                        <h1 class="card-title">Faire un Retrait</h1>
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
                        <form name="retraitForm" action="<?php echo base_url('/client/effectuerRetrait'); ?>" method="post" onsubmit="return validateForm()">
                            <div class="form-group">
                                <label for="montant">Montant du Retrait :</label>
                                <input type="number" class="form-control" id="montant" name="montant" required>
                            </div>
                            <!-- Champ caché pour l'ID de l'utilisateur -->
                            <input type="hidden" name="user_id" value="<?php echo session()->get('id'); ?>">
                            <br>
                            <button type="submit" class="btn btn-primary">Retirer</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <img src="<?php echo base_url('assets/images/retrait.gif'); ?>" class="img-fluid image-gif" alt="Retrait GIF">
                </div>
            </div>
        </div>
    </div>
</body>
</html>
