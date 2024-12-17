<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Route par défaut
$routes->get('/', 'TypesMassagesController::index');

// Routes pour les types de massages
$routes->get('TypesMassages', 'TypesMassagesController::index');
$routes->get('TypesMassages/create', 'TypesMassagesController::create', ['filter' => 'adminGuard']);
$routes->post('TypesMassages/create', 'TypesMassagesController::store', ['filter' => 'adminGuard']);
$routes->get('TypesMassages/edit/(:num)', 'TypesMassagesController::edit/$1', ['filter' => 'adminGuard']);
$routes->post('TypesMassages/update/(:num)', 'TypesMassagesController::update/$1', ['filter' => 'adminGuard']);
$routes->get('TypesMassages/delete/(:num)', 'TypesMassagesController::delete/$1', ['filter' => 'adminGuard']);
$routes->get('TypesMassages/success', 'TypesMassagesController::success', ['filter' => 'adminGuard']);

// Routes pour l'authentification
$routes->get('/inscription', 'InscriptionController::index');
$routes->post('/inscription', 'InscriptionController::traiteInscription');
$routes->get('/connexion', 'ConnexionController::index');
$routes->post('/connexion', 'ConnexionController::traiteConnexion');
$routes->get('/deconnexion', 'ConnexionController::deconnexion');

// Route pour le tableau de bord (protégée par le filtre d'authentification)
$routes->get('dashboard', 'DashboardController::index', ['filter' => 'adminGuard']);

$routes->get('/profile', 'ProfileController::index', ['filter' => 'authGuard']);
$routes->get('/profile/edit', 'ProfileController::edit', ['filter' => 'authGuard']);
$routes->post('/profile/update', 'ProfileController::update', ['filter' => 'authGuard']);

// Routes pour le panier
$routes->get('/panier', 'PanierController::index', ['filter' => 'authGuard']);
$routes->get('/panier/ajouter/(:num)', 'TypesMassagesController::details', ['filter' => 'authGuard']);
$routes->get('/panier/supprimer/(:num)', 'PanierController::supprimer/$1', ['filter' => 'authGuard']);
$routes->post('/panier/updateQuantite', 'PanierController::updateQuantite', ['filter' => 'authGuard']);
$routes->get('/panier/vider', 'PanierController::vider', ['filter' => 'authGuard']);

// Route pour servir les fichiers CSS statiques
$routes->get('assets/(:any)', 'Assets::serve/$1');

// Routes pour le panier avec correction du chemin
$routes->get('Panier/ajouter/(:num)', 'TypesMassagesController::details', ['filter' => 'authGuard']);
$routes->get('massage_details', 'TypesMassagesController::details');
$routes->post('massage_details/reserver', 'TypesMassagesController::reserver', ['filter' => 'authGuard']);

// Routes pour les réservations
$routes->get('reservations', 'ReservationsController::index', ['filter' => 'adminGuard']);
$routes->post('reservations/create', 'ReservationsController::create', ['filter' => 'authGuard']);

// Routes pour les logs
$routes->get('logs', 'LogsController::index', ['filter' => 'adminGuard']);
$routes->post('logs', 'LogsController::store', ['filter' => 'adminGuard']);
$routes->get('logs/(:num)', 'LogsController::show/$1', ['filter' => 'adminGuard']);