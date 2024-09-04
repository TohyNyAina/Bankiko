<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dépôt</title>
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
</head>
<body>
    <?php include('navbar.php'); ?>
    <div class="container mt-5">
        <div class="card card-custom">
            <div class="row g-0">
                <div class="col-md-8">
                    <div class="card-body">
                        <h1 class="card-title">Dépôt</h1>
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
                        <form action="/client/depot" method="post">
                            <div class="mb-3">
                                <label for="montant" class="form-label">Montant du dépôt</label>
                                <input type="number" class="form-control" name="montant" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Effectuer Dépôt</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <img src="<?php echo base_url('assets/images/depot.gif'); ?>" class="img-fluid image-gif" alt="Dépôt GIF">
                </div>
            </div>
        </div>
    </div>
</body>
</html>
