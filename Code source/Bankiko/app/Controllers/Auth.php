<?php

namespace App\Controllers;

use App\Models\UtilisateurModel;
use App\Models\CompteModel;
use App\Models\PretModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function registerUser()
    {
        $model = new UtilisateurModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');
        $email = $this->request->getPost('email');
        $telephone = $this->request->getPost('telephone');

        // Vérification de la correspondance des mots de passe
        if ($password !== $confirmPassword) {
            return redirect()->to('/register')->with('error', 'Les mots de passe ne correspondent pas.');
        }

        // Vérification si l'email est déjà utilisé
        $existingUserByEmail = $model->where('email', $email)->first();
        if ($existingUserByEmail) {
            return redirect()->to('/register')->with('error', 'Cet email est déjà utilisé.');
        }

        // Vérification si le mot de passe est déjà utilisé par un autre utilisateur
        $existingUserByPassword = $model->where('password', password_hash($password, PASSWORD_DEFAULT))->first();
        if ($existingUserByPassword) {
            return redirect()->to('/register')->with('error', 'Ce mot de passe est déjà utilisé par un autre utilisateur. Veuillez en choisir un autre.');
        }

        $data = [
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'email' => $email,
            'telephone' => $telephone,
            'role' => 'client' // Par défaut, le rôle est "client"
        ];

        // Insérer l'utilisateur
        $model->insert($data);

        // Récupérer l'ID de l'utilisateur inséré
        $userId = $model->getInsertID();

        // Créer une entrée dans la table Compte avec l'ID utilisateur
        $compteModel = new CompteModel();
        $compteData = [
            'utilisateur_id' => $userId,
            'solde' => 0 // Solde initial
        ];
        $compteModel->insert($compteData);

        // Récupérer l'ID du compte créé
        $compteId = $compteModel->getInsertID();

        // Créer une entrée dans la table Prêt avec l'ID du compte
        $pretModel = new PretModel();
        $pretData = [
            'compte_id' => $compteId,
            'montant' => 0, // Valeur initiale ou laissez à zéro
            'status' => 'inactif' // Par défaut, le prêt est inactif
        ];
        $pretModel->insert($pretData);

        return redirect()->to('/login');
    }

    public function loginUser()
    {
        $model = new UtilisateurModel();
        $email = $this->request->getPost('email');  // Utilisation de l'email pour la connexion
        $password = $this->request->getPost('password');

        // Rechercher l'utilisateur par email
        $user = $model->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            // Stocker les informations de l'utilisateur dans la session
            session()->set('isLoggedIn', true);
            session()->set('username', $user['username']);
            session()->set('id', $user['id']);  // Stockage de l'ID de l'utilisateur dans la session
            session()->set('role', $user['role']);  // Stocker le rôle pour les redirections conditionnelles

            // Rediriger en fonction du rôle de l'utilisateur
            if ($user['role'] === 'admin') {
                return redirect()->to('/admin');
            } else {
                return redirect()->to('/client');
            }
        } else {
            // Si la vérification échoue, rediriger vers la page de connexion avec un message d'erreur
            return redirect()->to('/login')->with('error', 'Email ou mot de passe invalide');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
