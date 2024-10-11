<?php
namespace Ninja;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Authentication {
    private $users;
    private $usernameColumn;
    private $passwordColumn;
    private $secretKey;

    public function __construct(DatabaseTable $users, $usernameColumn, $passwordColumn, $secretKey) {
        $this->users = $users;
        $this->usernameColumn = $usernameColumn;
        $this->passwordColumn = $passwordColumn;
        $this->secretKey = $secretKey;
    }

    public function login($username, $password) {
        // Authenticate with Supabase and get JWT token
        $supabaseUrl = 'https://your-supabase-url.supabase.co';
        $supabaseKey = 'your-supabase-key';
        $authUrl = $supabaseUrl . '/auth/v1/token?grant_type=password';

        $data = [
            'email' => $username,
            'password' => $password
        ];

        $options = [
            'http' => [
                'header'  => "Content-type: application/json\r\nAuthorization: Bearer $supabaseKey\r\n",
                'method'  => 'POST',
                'content' => json_encode($data),
            ],
        ];

        $context  = stream_context_create($options);
        $result = file_get_contents($authUrl, false, $context);

        if ($result === FALSE) {
            return false;
        }

        $response = json_decode($result, true);
        if (isset($response['access_token'])) {
            return $response['access_token'];
        } else {
            return false;
        }
    }

    public function validateToken($token) {
        try {
            $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));
            return (array) $decoded;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function isLoggedIn($token) {
        $decoded = $this->validateToken($token);
        if ($decoded) {
            $user = $this->users->find($this->usernameColumn, strtolower($decoded['sub']));
            if (!empty($user)) {
                return true;
            }
        }
        return false;
    }

    public function getUser($token) {
        $decoded = $this->validateToken($token);
        if ($decoded) {
            return $this->users->find($this->usernameColumn, strtolower($decoded['sub']))[0];
        } else {
            return false;
        }
    }
}