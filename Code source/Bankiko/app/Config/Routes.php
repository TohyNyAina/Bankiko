<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//  ================================AUTHENTIFICATION ROUTES=====================
$routes->get('/', 'Home::affichage');
$routes->get('/login', 'Auth::login');
$routes->post('/loginUser', 'Auth::loginUser');
$routes->get('/register', 'Auth::register');
$routes->post('/registerUser', 'Auth::registerUser');
$routes->get('/logout', 'Auth::logout');
$routes->get('/client', 'Client::index'); 
$routes->get('/admin', 'Admin::index'); 

// ==================================CLIENT ROUTES==============================

$routes->get('/client/dashboard', 'Client::dashboard');  
$routes->get('/client/solde', 'Client::solde');  
$routes->get('/client/depot', 'Client::depot');  
$routes->post('/client/depot', 'Client::effectuerDepot');  
$routes->get('/client/retrait', 'Client::retrait'); 
$routes->post('/client/effectuerRetrait', 'Client::effectuerRetrait');  
$routes->get('/client/pret', 'Client::pret');  
$routes->post('/client/demanderPret', 'Client::demanderPret');  

// ===================================ADMIN ROUTES===============================
$routes->get('/admin', 'Admin::index');
$routes->get('/admin/gestionUtilisateurs', 'Admin::gestionUtilisateurs');
$routes->get('/admin/historiqueTransactions', 'Admin::historiqueTransactions');
$routes->get('/admin/modifierUtilisateur/(:num)', 'Admin::modifierUtilisateur/$1');
$routes->post('/admin/modifierUtilisateur/(:num)', 'Admin::modifierUtilisateur/$1');
$routes->get('/admin/supprimerUtilisateur/(:num)', 'Admin::supprimerUtilisateur/$1');
$routes->get('/admin/supprimerTransaction/(:num)', 'Admin::supprimerTransaction/$1');



