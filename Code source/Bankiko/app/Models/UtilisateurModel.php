<?php

namespace App\Models;

use CodeIgniter\Model;

class UtilisateurModel extends Model
{
    protected $table = 'utilisateurs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'email', 'telephone', 'role'];
}
