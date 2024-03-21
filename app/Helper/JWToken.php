<?php

namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWToken
{
    // public static function createToken($userData):string {
    //     $key = env('JWT_KEY');
    //     // $key = 'lara-jwt-auth-1234';

    //     $payload = [
    //       'iss' => 'lara-jwt-auth',
    //       'iat' => time(),
    //       'exp' => time() + 3600, // 1 hour
    //     //   'userData' => $userData
    //       'userData' => [
    //           'id' => $userData->id,
    //           'firstName' => $userData->firstName,
    //           'lastName' => $userData->lastName,
    //           'email' => $userData->email,
    //           'role' => $userData->role,
    //           'status' => $userData->status,
    //       ]
    //     ];

    //     return JWT::encode($payload, $key, 'HS256');

    // }

    public static function createToken($email, $id):string {
        $key = env('JWT_KEY');

        $payload = [
          'iss' => 'lara-jwt-auth',
          'iat' => time(),
          'exp' => time() + 3600, // 1 hour
          'email' => $email,
          'id' => $id
        ];

        return JWT::encode($payload, $key, 'HS256');
    }

    public static function createTokenForResetPassword($email):string {
        $key = env('JWT_KEY');
        // $key = 'lara-jwt-auth-1234';

        $payload = [
          'iss' => 'lara-jwt-auth',
          'iat' => time(),
          'exp' => time() + 600, // 10 minutes
          'email' => $email,
          'id' => '0'
        ];

        return JWT::encode($payload, $key, 'HS256');

    }

    public static function verifyToken($token):string|object {

        try{
            if($token == null){
                return 'unauthorized';
            }else{
                $key = env('JWT_KEY');
                // $key = 'lara-jwt-auth-1234';
                $decode = JWT::decode($token, new Key($key, 'HS256'));
                return $decode;
            }
        }
        catch(Exception $e){
            // return 'Un-Authorized...'. $e->getMessage();
            return 'unauthorized';
            // return [
            //     'status' => 'error',
            //     'message' => 'Un-Authorized...' . $e
            // ];
        }

    }
}
