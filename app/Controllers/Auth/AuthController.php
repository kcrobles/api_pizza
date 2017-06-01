<?php

namespace App\Controllers\Auth;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Firebase\JWT\JWT;
use Respect\Validation\Validator as v;
use App\Controllers\Controller;
use App\Models\User;

class AuthController extends Controller {

    private $key = "my_secret_api_key";

    public function attempt(Request $request, Response $response)
    {
        if(User::where('email', $request->getParam('email'))->count() < 1)
        {
            return $response->withJson([
                "status" => "error",
                "message" => ["email" => "El email ingresado no existe"]
            ], 404);
        }

        $auth = $this->auth->attempt(
            $request->getParam('email'), $request->getParam('password'), true
        );

        if($auth === false)
        {
            return $response->withJson([
				"status" => "error",
				"message" => ["password" => "La contraseña no coincide"]
			], 404);
        }

        $token = [
            "iat" => time(),
            "exp" => time() + 60 * 60 ,
            "sub" => $auth->id,
            "role" =>$auth->role()->role_name,
            "user" => array(
                "firstName" => $auth->firstName,
                "lastName" => $auth->lastName
                "email" => $auth->email
            )
        ];

        $jwt = JWT::encode($token, $this->key);

        return $response->withJson([
            "status" => "success",
            "token" => $jwt
        ]);
    }

    public function login(Request $request, Response $response)
    {
        if(Customer::where('email', $request->getParam('email'))->count() < 1)
        {
            return $response->withJson([
                "status" => "error",
                "message" => ["email" => "El email ingresado no existe"]
            ], 404);
        }

        $auth = $this->auth->attempt(
            $request->getParam('email'), $request->getParam('password')
        );

        if($auth === false)
        {
            return $response->withJson([
                "status" => "error",
                "message" => ["password" => "La contraseña no coincide"]
            ], 404);
        }
        $token = [
            "iat" => time(),
            "exp" => time() + 60 * 60 ,
            "sub" => $auth->id,
            "user" => array(
                "name" => $auth->name,
                "email" => $auth->email
            )
        ];

        $jwt = JWT::encode($token, $this->key);

        return $response->withJson([
            "status" => "success",
            "token" => $jwt
        ]);
    }

    public function checkToken($token, $decode_flag = false)
    {
        $key = $this->key;
		$auth = false;

		try
        {
			$decoded = JWT::decode($token, $key, array('HS256'));
		}catch(\UnexpectedValueException $e){
			$auth = false;
		}catch(\DomainException $e){
			$auth = false;
		}

		if(isset($decoded->sub))
        {
			$auth = true;
		} else {
			$auth = false;
		}

		if($decode_flag == true)
        {
			return $decoded;
		} else {
			return $auth;
		}
    }
}
