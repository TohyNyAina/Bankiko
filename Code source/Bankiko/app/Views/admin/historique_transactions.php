<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Transactions</title>
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
    <h1>Historique des Transactions</h1>
    <br>
        <div class="card card-custom">
            <div class="card-body">
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID Transaction</th>
                            <th>ID Compte</th>
                            <th>Type</th>
                            <th>Montant</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transactions as $transaction): ?>
                            <tr>
                                <td><?= $transaction['id'] ?></td>
                                <td><?= $transaction['compte_id'] ?></td>
                                <td><?= $transaction['type'] ?></td>
                                <td><?= number_format($transaction['montant'], 2) ?> MGA</td>
                                <td><?= $transaction['date'] ?></td>
                                <td>
                                    <a href="/admin/supprimerTransaction/<?= $transaction['id'] ?>" class="btn btn-danger">Supprimer</a>
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
