<?php

namespace App\Controllers;

use App\Classes\DB;
use App\Classes\Response;
use App\Classes\Str;
use App\Services\RequestValidationService;

class LoginController
{
    public function login(): Response
    {
        $validator = RequestValidationService::create([
            'username' => 'required|exists:users,name',
            'password' => 'required'
        ]);

        if (!$validator->validate()) {
            return $validator->getResponse();
        }

        $body = $validator->getBody();

        $query = 'SELECT * FROM users WHERE name = :name';

        $user = DB::fetch($query, [
            'name' => $body['username']
        ]);

        if (!$user) {
            return Response::create([], 500);
        }

        if (!password_verify($body['password'], $user['password'])) {
            return Response::create([], 409);
        }

        $apiToken = Str::random(80);

        DB::query('UPDATE users SET api_token = :api_token WHERE id = :id', [
            'api_token' => $apiToken,
            'id'        => $user['id']
        ]);

        return Response::create([
            'name'      => $user['name'],
            'api_token' => $apiToken
        ]);
    }
}
