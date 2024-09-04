<?php

namespace App\Controllers;

use App\Models\UtilisateurModel;
use App\Models\CompteModel;
use App\Models\TransactionModel;
use App\Models\PretModel;

class Admin extends BaseController
{
    public function __construct()
    {
        // Vérifier l'accès de l'administrateur
        $this->_checkAdminAccess();
    }

    private function _checkAdminAccess()
    {
        if (!session()->get('isLoggedIn') || session()->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Accès non autorisé.');
        }
    }

    public function index()
    {
        $utilisateurModel = new UtilisateurModel();
        $compteModel = new CompteModel();
        $transactionModel = new TransactionModel();

        // Compter le nombre total de clients
        $totalClients = $utilisateurModel->where('role', 'client')->countAllResults();

        // Calculer le total des soldes déposés
        $totalDepots = $compteModel->selectSum('solde')->get()->getRow()->solde;

        // Calculer le total des montants retirés
        $totalRetraits = $transactionModel->where('type', 'retrait')->selectSum('montant')->get()->getRow()->montant;

        // Passer les données au tableau de bord
        $data = [
            'totalClients' => $totalClients,
            'totalDepots' => $totalDepots,
            'totalRetraits' => $totalRetraits,
        ];

        return view('admin/dashboard', $data);
    }

    public function gestionUtilisateurs()
    {
        $model = new UtilisateurModel();
        $data['utilisateurs'] = $model->findAll();
        return view('admin/gestion_utilisateurs', $data);
    }

    public function historiqueTransactions()
    {
        $transactionModel = new TransactionModel();
        $data['transactions'] = $transactionModel->findAll();
        return view('admin/historique_transactions', $data);
    }

    public function supprimerUtilisateur($id)
    {
        $compteModel = new CompteModel();
        $utilisateurModel = new UtilisateurModel();
        $pretModel = new PretModel(); // Utilisation du modèle PretModel pour les prêts
    
        // Récupérer tous les comptes associés à l'utilisateur
        $comptes = $compteModel->where('utilisateur_id', $id)->findAll();
    
        // Supprimer les prêts associés à chaque compte
        foreach ($comptes as $compte) {
            $pretModel->where('compte_id', $compte['id'])->delete();
        }
    
        // Supprimer les comptes associés à l'utilisateur
        $compteModel->where('utilisateur_id', $id)->delete();
    
        // Supprimer l'utilisateur
        if ($utilisateurModel->delete($id)) {
            return redirect()->to('/admin/gestionUtilisateurs')->with('message', 'Utilisateur supprimé avec succès.');
        } else {
            return redirect()->to('/admin/gestionUtilisateurs')->with('error', 'Erreur lors de la suppression de l\'utilisateur.');
        }
    }
    


    public function modifierUtilisateur($id)
    {
        $model = new UtilisateurModel();
        $utilisateur = $model->find($id);
    
        if ($this->request->getMethod() === 'post') {
            // Récupérer les données du formulaire
            $data = [
                'username' => $this->request->getPost('username'),
                'telephone' => $this->request->getPost('telephone'), 
                'email' => $this->request->getPost('email'),
                'role' => $this->request->getPost('role'),
            ];
    
    
            // Mettre à jour l'utilisateur
            if ($model->update($id, $data)) {
                return redirect()->to('/admin/gestionUtilisateurs')->with('message', 'Utilisateur modifié avec succès.');
            } else {
                return redirect()->to('/admin/modifierUtilisateur/'.$id)->with('error', 'Erreur lors de la modification de l\'utilisateur.');
            }
        }
    
        return view('admin/modifier_utilisateur', ['utilisateur' => $utilisateur]);
    }
    

    // Nouvelle méthode pour supprimer un historique de transaction
    public function supprimerTransaction($id)
    {
        $transactionModel = new TransactionModel();
        $transactionModel->delete($id);
        return redirect()->to('/admin/historiqueTransactions')->with('message', 'Transaction supprimée avec succès.');
    }
}
