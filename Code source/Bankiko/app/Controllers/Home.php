<?php

namespace App\Controllers;


class Home extends BaseController
{

    public function affichage()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        return view('login');
    }
}
