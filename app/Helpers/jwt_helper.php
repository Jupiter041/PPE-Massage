<?php
use App\Models\UserModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
service('eloquent');

// Récupère le JWT du header d'authentification et retourne le token sans le prefix 'Bearer'
function getJWTFromRequest($authenticationHeader): string
{
    if (is_null($authenticationHeader)) { //JWT est absent
        throw new Exception('JWT manquant ou invalide dans la requête');
    }
    //Le JWT est envoyé par le client au format Bearer XXXXXXXXX
    return explode(' ', $authenticationHeader)[1];
}

// Valide le JWT fourni en vérifiant la signature et l'existence de l'utilisateur
function validateJWTFromRequest(string $encodedToken)
{
    $key = Services::getSecretKey();
    $decodedToken = JWT::decode($encodedToken, new Key($key, 'HS256'));
    $userModel = new UserModel();
    $user = $userModel->where('nom_utilisateur', $decodedToken->pseudo)->first();
    
    if (!$user) {
        throw new Exception('Utilisateur non trouvé');
    }
}

// Génère un nouveau JWT signé pour un utilisateur donné avec une durée de validité
function getSignedJWTForUser(string $pseudo)
{
    $issuedAtTime = time();
    $tokenTimeToLive = getenv('JWT_TIME_TO_LIVE');
    $tokenExpiration = $issuedAtTime + $tokenTimeToLive;
    $payload = [
        'pseudo' => $pseudo,
        'iat' => $issuedAtTime,
        'exp' => $tokenExpiration,
    ];

    $key = Services::getSecretKey();
    $jwt = JWT::encode($payload, $key, 'HS256');
    return $jwt;
}

// Récupère l'utilisateur connecté à partir du JWT dans le header d'authentification
function getConnectedUser(){
    $authHeader = getallheaders()['Authorization'];
    $token = getJWTFromRequest($authHeader);
    
    $key = Services::getSecretKey();
    $decoded = JWT::decode($token, new Key($key, 'HS256'));
    $pseudo = $decoded->pseudo;
    
    $user = UserModel::where('nom_utilisateur', $pseudo)->first();
    
    if (!$user) {
        throw new Exception('Utilisateur non trouvé');
    }
    
    return $user;
}