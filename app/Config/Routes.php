<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Route par défaut
$routes->get('/', 'TypesMassagesController::index');

// Routes pour les types de massages
$routes->get('TypesMassages', 'TypesMassagesController::index');
$routes->get('TypesMassages/create', 'TypesMassagesController::create');
$routes->post('TypesMassages/create', 'TypesMassagesController::store');
$routes->get('TypesMassages/edit/(:num)', 'TypesMassagesController::edit/$1');
$routes->post('TypesMassages/update/(:num)', 'TypesMassagesController::update/$1');
$routes->get('TypesMassages/delete/(:num)', 'TypesMassagesController::delete/$1');
$routes->get('TypesMassages/success', 'TypesMassagesController::success');
$routes->get('TypesMassages/details/(:num)', 'TypesMassagesController::details/$1');

// Routes pour l'authentification
$routes->get('/inscription', 'InscriptionController::index');
$routes->post('/inscription', 'InscriptionController::traiteInscription');
$routes->get('/connexion', 'ConnexionController::index');
$routes->post('/connexion', 'ConnexionController::traiteConnexion');
$routes->get('/deconnexion', 'ConnexionController::deconnexion');

// Route pour le tableau de bord
$routes->get('dashboard', 'DashboardController::index');

$routes->get('/profile', 'ProfileController::index');
$routes->get('/profile/edit', 'ProfileController::edit');
$routes->post('/profile/update', 'ProfileController::update');

// Routes pour le panier
$routes->get('/panier', 'PanierController::index');
$routes->get('/panier/ajouter/(:num)', 'PanierController::ajouter/$1');
$routes->get('/panier/supprimer/(:num)', 'PanierController::supprimer/$1');
$routes->get('/panier/vider', 'PanierController::vider');
$routes->post('/panier/ajouterMultiple', 'PanierController::ajouterMultiple');
$routes->post('/Reservation/ajouterMultiple', 'PanierController::ajouterMultiple');

// Route pour servir les fichiers CSS statiques
$routes->get('assets/(:any)', 'Assets::serve/$1');

// Routes pour la validation de commande
$routes->get('Reservations', 'ValidationCommandeController::index');
$routes->post('Reservations/create', 'ValidationCommandeController::create');
$routes->post('Reservations/transfererReservation/(:num)', 'ReservationsController::transfererReservation/$1');

// Routes pour les réservations
$routes->get('reservations', 'ReservationsController::index');
$routes->post('reservations/create', 'ReservationsController::create');

// Routes pour les logs
$routes->get('logs', 'LogsController::index');
$routes->post('logs', 'LogsController::store');
$routes->get('logs/(:num)', 'LogsController::show/$1');

// Ajout de la route pour gérer les erreurs 404
$routes->set404Override('ConnexionController::show404');

// Activation de l'auto-routing pour une meilleure gestion des routes 
$routes->setAutoRoute(false);

// Configuration du baseURL dans .env ou Config/App.php:
// base_url = 'http://localhost/~jupiter/PPE-Massage/public/'

// Routes pour l'API WebService
$routes->get('api/schedule/(:num)', 'WebServiceController::getData/$1');