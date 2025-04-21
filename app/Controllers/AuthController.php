<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\EmployeModel;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use Config\Services;

class AuthController extends BaseController
{

    public function login(){
        try {
            $pseudo = $this->request->getVar('pseudo');
            $password = $this->request->getVar('password');
            $user = UserModel::where('nom_utilisateur', $pseudo)->first();
            $pass = $user->mot_de_passe;
            $validatePassWord = password_verify($password, $pass); 
            if ($validatePassWord) {
                return $this->getJWTForUser($pseudo);
            } else {
                return $this->response->setJSON(['message' => 'Erreur d\'authentitification']);
            }
        } catch (Exception $th) {
            return $this->response->setJSON(['message' => 'Erreur d\'authentitification']);
        }
    }

    private function getJWTForUser($pseudo, $responseCode = ResponseInterface::HTTP_OK){
        try {
            $user = UserModel::where('nom_utilisateur', $pseudo)->first();
            unset($user->mot_de_passe);

            $employe = EmployeModel::where('compte_id', $user->compte_id)->first();
            $employeId = $employe ? $employe->employe_id : null;

            helper('jwt');

            return $this->response->setJSON(
                [
                    'message' => 'User authenticated Successfully',
                    'user' => $user,
                    'unique_id' => $user->id_utilisateur,
                    'employe_id' => $employeId,
                    'access_token' => getSignedJWTForUser((string)$pseudo),
                ]
            );
        } catch (Exception $exception) {
            return $this->response->setJSON(
                [
                    'error' => $exception->getMessage(),
                ],
                $responseCode
            );
        }
            
    }

}
