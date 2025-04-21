<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use Config\Filters;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Config\Services;

class JwtFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $response = service('response');

        try {
            $authenticationHeader = $request->getServer('HTTP_AUTHORIZATION');
            $encodedToken = $this->getJWTFromRequest($authenticationHeader);
            $this->validateJWTFromRequest($encodedToken);
            return $request;
        } catch (Exception $e) {
            return $response->setJSON([
                'error' => $e->getMessage()
            ])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }

    private function getJWTFromRequest($authenticationHeader): string
    {
        if (is_null($authenticationHeader)) {
            throw new Exception('Missing or invalid JWT in request');
        }
        return trim(str_replace('Bearer', '', $authenticationHeader));
    }

    private function validateJWTFromRequest($encodedToken)
    {
        $key = Services::getSecretKey();
        $decodedToken = JWT::decode($encodedToken, new Key($key, 'HS256'));
        return $decodedToken;
    }
}
