<?php

namespace App\Controllers;

use App\Models\CompteModel;
use App\Models\TransactionModel;
use App\Models\PretModel;

class Compte extends BaseController
{
    public function index()
    {
        $model = new CompteModel();
        $userId = session()->get('id');
        $compte = $model->where('utilisateur_id', $userId)->first();

        return view('client/dashboard', ['compte' => $compte]);
    }

    public function depot()
    {
        return view('client/depot.php');
    }

    public function retrait()
    {
        return view('client/retrait.php');
    }

    public function effectuerDepot()
    {
        $model = new CompteModel();
        $transactionModel = new TransactionModel();
        $userId = session()->get('id');
        $montant = $this->request->getPost('montant');

        $compte = $model->where('utilisateur_id', $userId)->first();
        $compte['solde'] += $montant;
        $model->save($compte);

        $transactionModel->save([
            'compte_id' => $compte['id'],
            'type' => 'depot',
            'montant' => $montant
        ]);

        return redirect()->to('/client')->with('success', 'Dépôt effectué avec succès.');
    }

    public function effectuerRetrait()
    {
        $model = new CompteModel();
        $transactionModel = new TransactionModel();
        $userId = session()->get('id');
        $montant = $this->request->getPost('montant');

        $compte = $model->where('utilisateur_id', $userId)->first();
        if ($montant > $compte['solde']) {
            return redirect()->to('/client')->with('error', 'Retrait impossible, solde insuffisant.');
        }

        $compte['solde'] -= $montant;
        $model->save($compte);

        $transactionModel->save([
            'compte_id' => $compte['id'],
            'type' => 'retrait',
            'montant' => $montant
        ]);

        return redirect()->to('/client')->with('success', 'Retrait effectué avec succès.');
    }

    public function pret()
    {
        return view('client/pret');
    }

    public function demanderPret()
    {
        $model = new CompteModel();
        $pretModel = new PretModel();
        $userId = session()->get('id');
        $montant = $this->request->getPost('montant');

        $compte = $model->where('utilisateur_id', $userId)->first();
        $pretEnCours = $pretModel->where('compte_id', $compte['id'])
                                 ->where('status', 'en_cours')
                                 ->first();

        if ($pretEnCours) {
            return redirect()->to('/client')->with('error', 'Vous avez déjà un prêt en cours.');
        }

        $pretModel->save([
            'compte_id' => $compte['id'],
            'montant' => $montant,
            'rembourser' => $montant
        ]);

        $compte['solde'] += $montant;
        $model->save($compte);

        return redirect()->to('/client')->with('success', 'Prêt accordé avec succès.');
    }
}
