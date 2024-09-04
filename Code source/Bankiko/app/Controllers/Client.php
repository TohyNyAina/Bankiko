<?php

namespace App\Controllers;

use App\Models\UtilisateurModel;
use App\Models\CompteModel;
use App\Models\TransactionModel;
use App\Models\PretModel;

class Client extends BaseController
{
    public function __construct()
    {
        $this->_checkClientAccess();
    }

    private function _checkClientAccess()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'client') {
            return redirect()->to('/login')->with('error', 'Accès non autorisé.');
        }
    }

    public function index()
    {
        $userId = $this->_getUserId();

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Utilisateur non trouvé.');
        }

        $compteModel = new CompteModel();
        $compte = $compteModel->where('utilisateur_id', $userId)->first();

        if (!$compte) {
            $data['compte'] = [
                'solde' => 0
            ];
            session()->setFlashdata('error', 'Compte non trouvé, veuillez contacter l\'administration.');
        } else {
            $data['compte'] = $compte;
        }

        return view('client/dashboard', $data);
    }

    public function solde()
    {
        $userId = $this->_getUserId();

        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Utilisateur non trouvé.');
        }

        $compteModel = new CompteModel();
        $compte = $compteModel->where('utilisateur_id', $userId)->first();

        if (!$compte) {
            $data['compte'] = ['solde' => 0];
            session()->setFlashdata('error', 'Compte non trouvé, veuillez contacter l\'administration.');
        } else {
            $data['compte'] = $compte;
        }

        return view('client/solde', $data);
    }

    public function depot()
    {
        return view('client/depot');
    }

    public function effectuerDepot()
    {
        $montant = $this->request->getPost('montant');
        $userId = session()->get('id');
    
        log_message('debug', 'Montant de dépôt reçu : ' . $montant);
        log_message('debug', 'ID de l\'utilisateur connecté : ' . $userId);
    
        $compteModel = new CompteModel();
        $compte = $compteModel->where('utilisateur_id', $userId)->first();
        $pretModel = new PretModel();
    
        if (!$compte) {
            log_message('error', 'Aucun compte trouvé pour l\'utilisateur ID : ' . $userId);
            return redirect()->back()->with('error', 'Compte non trouvé. Veuillez contacter l\'administration.');
        }
    
        if ($montant <= 0) {
            log_message('error', 'Montant de dépôt invalide : ' . $montant);
            return redirect()->back()->with('error', 'Le montant du dépôt doit être supérieur à zéro.');
        }
    
        // Vérifier s'il y a un prêt actif
        $pretActif = $pretModel->where('compte_id', $compte['id'])->where('montant >', 0)->first();
    
        if ($pretActif) {
            // Calculer le remboursement
            $montantRestant = $pretActif['montant'] - $montant;
    
            if ($montantRestant <= 0) {
                // Le prêt est complètement remboursé
                $pretActif['montant'] = 0;
                $pretModel->save($pretActif);
    
                // Ajouter le reste du montant au solde
                $compte['solde'] += -$montantRestant; // Utiliser le montant restant comme dépôt
            } else {
                // Le prêt n'est pas complètement remboursé
                $pretActif['montant'] = $montantRestant;
                $pretModel->save($pretActif);
            }
        } else {
            // Aucun prêt actif, ajouter le montant au solde
            $compte['solde'] += $montant;
        }
    
        if (!$compteModel->save($compte)) {
            log_message('error', 'Échec de la mise à jour du compte ID : ' . $compte['id']);
            return redirect()->back()->with('error', 'Échec du dépôt. Veuillez réessayer.');
        }
    
        // Enregistrer la transaction
        $transactionModel = new TransactionModel();
        $transactionData = [
            'compte_id' => $compte['id'],
            'type' => 'depot',
            'montant' => $montant,
            'date' => date('Y-m-d H:i:s')
        ];
    
        if (!$transactionModel->save($transactionData)) {
            log_message('error', 'Échec de l\'insertion de la transaction pour le compte ID : ' . $compte['id']);
            return redirect()->back()->with('error', 'Échec de l\'enregistrement de la transaction.');
        }
    
        log_message('info', 'Dépôt réussi de ' . $montant . ' € pour le compte ID : ' . $compte['id']);
    
        return redirect()->to('/client')->with('message', 'Dépôt effectué avec succès.');
    }    

    public function retrait()
    {
        return view('client/retrait');
    }

    public function effectuerRetrait()
    {
        $montant = $this->request->getPost('montant');
        $userId = session()->get('id');
        $compteModel = new CompteModel();
        $compte = $compteModel->where('utilisateur_id', $userId)->first();

        if (!$compte) {
            return redirect()->to('/client/retrait')->with('error', 'Compte non trouvé. Veuillez contacter l\'administration.');
        }

        if ($montant <= 0) {
            return redirect()->back()->with('error', 'Le montant du retrait doit être un nombre positif.');
        }

        if ($montant > $compte['solde']) {
            return redirect()->to('/client/retrait')->with('error', 'Solde insuffisant.');
        }

        $compte['solde'] -= $montant;
        $compteModel->save($compte);

        // Enregistrer la transaction
        $transactionModel = new TransactionModel();
        $transactionModel->save([
            'compte_id' => $compte['id'],
            'type' => 'retrait',
            'montant' => $montant,
            'date' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/client')->with('message', 'Retrait effectué avec succès.');
    }

    public function pret()
    {
        return view('client/pret');
    }

    public function demanderPret()
{
    $userId = session()->get('id');
    $pretModel = new PretModel();
    $compteModel = new CompteModel();
    $compte = $compteModel->where('utilisateur_id', $userId)->first();

    if (!$compte) {
        return redirect()->to('/client/pret')->with('error', 'Compte non trouvé. Veuillez contacter l\'administration.');
    }

    // Vérifier s'il y a un prêt actif non remboursé
    $pretActif = $pretModel->where('compte_id', $compte['id'])->where('montant >', 0)->first();

    if ($pretActif) {
        return redirect()->to('/client/pret')->with('error', 'Vous avez déjà un prêt en cours. Veuillez rembourser le prêt actuel avant d\'en demander un autre.');
    }

    $montant = $this->request->getPost('montant');

    // Vérifier si le montant est négatif ou nul
    if ($montant <= 0) {
        return redirect()->to('/client/pret')->with('error', 'Le montant du prêt doit être un nombre positif.');
    }

    // Vérifier s'il y a un prêt remboursé
    $pretRembourse = $pretModel->where('compte_id', $compte['id'])->where('montant', 0)->first();

    if ($pretRembourse) {
        // Réutiliser l'entrée de prêt remboursé
        $pretRembourse['montant'] = $montant;
        $pretRembourse['date_creation'] = date('Y-m-d'); // Mise à jour de la date de création
        $pretModel->save($pretRembourse);
    } else {
        // Créer un nouveau prêt s'il n'y en a pas de remboursé
        $pretModel->save([
            'compte_id' => $compte['id'],
            'montant' => $montant,
            'date_creation' => date('Y-m-d')
        ]);
    }

    return redirect()->to('/client')->with('message', 'Prêt demandé avec succès.');
}
    

    private function _getUserId()
    {
        $username = session()->get('username');
        if (!$username) {
            return null;
        }

        $utilisateurModel = new UtilisateurModel();
        $user = $utilisateurModel->where('username', $username)->first();
        return $user ? $user['id'] : null;
    }

    public function mettreAJourInterets()
    {
        $pretModel = new PretModel();
        $today = date('Y-m-d');
        $pretActifs = $pretModel->where('montant >', 0)->findAll();

        foreach ($pretActifs as $pret) {
            // Calculer les intérêts en fonction de la durée
            $startDate = new \DateTime($pret['date_creation']);
            $endDate = new \DateTime($today);
            $interval = $startDate->diff($endDate);
            $days = $interval->days;

            // Ajouter les intérêts au montant du prêt
            $interests = $pret['montant'] * (0.05 * $days / 365); // Exemple d'intérêt de 5% par an
            $pret['montant'] += $interests;

            $pretModel->save($pret);
        }

        return redirect()->to('/client')->with('message', 'Intérêts des prêts mis à jour.');
    }
}
