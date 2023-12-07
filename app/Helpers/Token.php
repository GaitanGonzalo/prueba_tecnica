<?php

namespace App\Helpers;

use PhpParser\Node\Stmt\TryCatch;

Class Token {
    
    /**
     * this fn generate the token with user data
     * @param info Object
     * @param timeLife Integer => default 3600 sec
     * @return String 
     */
    static function createToken(Mixed $info, Int $timeLife = 3600): String{
        $secret = env('SECRET');
        $exp = time() + $timeLife;
        $data = ['info'=>$info, 'expiration'=>$exp];
        $hash = hash_hmac('sha1', json_encode($data), $secret);
            $token = base64_encode(json_encode($data)).'.'.$hash;
        return $token;
    }

    static function decodeToken(String $token){
        try {
        $secret = env('SECRET');
        $segment = explode('.', $token);
        $tokenData = json_decode(base64_decode($segment[0]), true);
        $tokenHash = hash_hmac('sha1', json_encode($tokenData), $secret);
        
        if(!hash_equals($tokenHash, $segment[1])) return ['message'=>'Invalid token', 'statusCode'=>401];
        
        $tokenData = json_decode(base64_decode($segment[0]), true);
        if(!($tokenData['expiration'] >= time())) return ['message'=>'Expired token', 'statusCode'=>401];
        
        return $tokenData['info'];

        } catch (\Throwable $th) {
           return ['message'=>$th->getMessage(), 'statusCode'=>500];
        }
        
        
    }

    function checkHash($hash1, $hash2):bool{
        return hash_equals($hash1, $hash2);
    }
}