<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require __DIR__ . '/../vendor/autoload.php';

define('JWT_SECRET', 'your_super_secret_key'); // Use a strong key

class Token {
    public static function create($user_id) {
        $payload = [
            "iss" => "http://localhost",
            "aud" => "http://localhost",
            "iat" => time(),
            "exp" => time() + 3600, // 1 hour
            "uid" => $user_id
        ];
        return JWT::encode($payload, JWT_SECRET, 'HS256');
    }

    public static function verify($token) {
        try {
            $decoded = JWT::decode($token, new Key(JWT_SECRET, 'HS256'));
            return $decoded->uid;
        } catch (Exception $e) {
            return false;
        }
    }
}
