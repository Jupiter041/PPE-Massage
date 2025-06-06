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
$routes->get('TypesMassages/success', 'TypesMassagesController::success');
$routes->get('TypesMassages/details/(:num)', 'TypesMassagesController::details/$1');
$routes->get('TypesMassages/en_attente/(:num)', 'EnAttenteController::index/$1', ['filter' => 'authGuard']);

// Routes pour les empêchements
$routes->get('empechements', 'EmpechementController::index', ['filter' => 'adminGuard']);
$routes->get('empechement/delete/(:num)', 'EmpechementController::delete/$1', ['filter' => 'adminGuard']);
$routes->get('admin/empechements', 'EmpechementController::index', ['filter' => 'adminGuard']);
$routes->get('admin/empechements/create', 'EmpechementController::create', ['filter' => 'adminGuard']);
$routes->post('admin/empechements/store', 'EmpechementController::store', ['filter' => 'adminGuard']);
$routes->get('admin/empechements/edit/(:num)', 'EmpechementController::edit/$1', ['filter' => 'adminGuard']);
$routes->post('admin/empechements/update/(:num)', 'EmpechementController::update/$1', ['filter' => 'adminGuard']);
$routes->get('admin/empechements/delete/(:num)', 'EmpechementController::delete/$1', ['filter' => 'adminGuard']);

// Routes pour l'authentification
$routes->get('/inscription', 'InscriptionController::index');
$routes->post('/inscription', 'InscriptionController::traiteInscription');
$routes->get('/connexion', 'ConnexionController::index');
$routes->post('/connexion', 'ConnexionController::traiteConnexion');
$routes->get('/deconnexion', 'ConnexionController::deconnexion');

// Routes pour l'API JWT
$routes->post('auth/login', 'AuthController::login');

// Route pour le tableau de bord
$routes->get('dashboard', 'DashboardController::index', ['filter' => 'adminGuard']);

$routes->get('/profile', 'ProfileController::index', ['filter' => 'authGuard']);
$routes->get('/profile/edit', 'ProfileController::edit', ['filter' => 'authGuard']);
$routes->post('/profile/update', 'ProfileController::update', ['filter' => 'authGuard']);

// Routes pour le panier
$routes->get('/panier', 'PanierController::index', ['filter' => 'authGuard']);
$routes->get('/panier/ajouter/(:num)', 'PanierController::ajouter/$1', ['filter' => 'authGuard']);
$routes->get('/panier/supprimer/(:num)', 'PanierController::supprimer/$1', ['filter' => 'authGuard']);
$routes->get('/panier/vider', 'PanierController::vider', ['filter' => 'authGuard']);
$routes->post('/panier/ajouterMultiple', 'PanierController::ajouterMultiple', ['filter' => 'authGuard']);

// Routes pour les réservations
$routes->get('reservations', 'ReservationsController::create', ['filter' => 'authGuard']);
$routes->get('reservations/create', 'ReservationsController::create', ['filter' => 'authGuard']);

// Routes pour les réservations en attente
$routes->post('/EnAttente/create', 'EnAttenteController::create', ['filter' => 'authGuard']);
$routes->get('/EnAttente/edit/(:num)', 'EnAttenteController::edit/$1', ['filter' => 'authGuard']);
$routes->get('/EnAttente/deleteReservationWithPanier/(:num)', 'EnAttenteController::deleteReservationWithPanier/$1', ['filter' => 'authGuard']);

// Route pour servir les fichiers CSS statiques
$routes->get('assets/(:any)', 'Assets::serve/$1');

// Routes pour les logs
$routes->get('logs', 'LogsController::index', ['filter' => 'adminGuard']);
$routes->post('logs', 'LogsController::store', ['filter' => 'adminGuard']);
$routes->get('logs/(:num)', 'LogsController::show/$1', ['filter' => 'adminGuard']);

// Routes pour la gestion des employés
$routes->get('admin/gestion/employes', 'GereEmployeController::index', ['filter' => 'adminGuard']);
$routes->get('admin/gestion/employes/create', 'GereEmployeController::showCreate', ['filter' => 'adminGuard']);
$routes->post('admin/gestion/employes/create', 'GereEmployeController::create', ['filter' => 'adminGuard']);
$routes->get('admin/gestion/employes/edit/(:num)', 'GereEmployeController::edit/$1', ['filter' => 'adminGuard']);
$routes->post('admin/gestion/employes/update/(:num)', 'GereEmployeController::update/$1', ['filter' => 'adminGuard']);
$routes->get('admin/gestion/employes/delete/(:num)', 'GereEmployeController::delete/$1', ['filter' => 'adminGuard']);

// Routes pour la gestion des salles
$routes->get('admin/gestion/salles', 'GereSalleController::index', ['filter' => 'adminGuard']);
$routes->get('admin/gestion/salles/create', 'GereSalleController::showCreate', ['filter' => 'adminGuard']);
$routes->post('admin/gestion/salles/create', 'GereSalleController::create', ['filter' => 'adminGuard']);
$routes->get('admin/gestion/salles/edit/(:num)', 'GereSalleController::edit/$1', ['filter' => 'adminGuard']);
$routes->post('admin/gestion/salles/update/(:num)', 'GereSalleController::update/$1', ['filter' => 'adminGuard']);
$routes->get('admin/gestion/salles/delete/(:num)', 'GereSalleController::delete/$1', ['filter' => 'adminGuard']);

// Ajout de la route pour gérer les erreurs 404
//$routes->set404Override('ConnexionController::show404');

// Désactiver l'auto-routage
$routes->setAutoRoute(false);

// Routes pour l'API WebService
$routes->get('api/schedule/(:num)', 'WebServiceController::getData/$1', ['filter' => 'jwt']);
$routes->get('api/comments', 'WebServiceController::getComments', ['filter' => 'jwt']);
$routes->get('api/comments/(:num)', 'WebServiceController::getComments/$1', ['filter' => 'jwt']);
$routes->get('api/employe/(:num)/creneaux', 'EmployeController::getTimeSlots/$1', ['filter' => 'jwt']);
$routes->post('api/empechements', 'WebServiceController::createEmpechement', ['filter' => 'jwt']);

//$routes->get('/employe/hours', 'EmployeController::hours', ['filter' => 'adminGuard']);

// Routes pour creneaux disponibles
$routes->get('EnAttente/getAvailableSlots', 'EnAttenteController::getAvailableSlots');
