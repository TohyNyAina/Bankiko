<?php

namespace App\Models;

use CodeIgniter\Model;

class PretModel extends Model
{
    protected $table = 'prets';
    protected $primaryKey = 'id';
    protected $allowedFields = ['compte_id', 'montant', 'rembourser', 'status', 'date_emprunt'];
}
