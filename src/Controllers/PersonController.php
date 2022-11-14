<?php

namespace App\Controllers;

use App\Classes\DB;
use App\Classes\Response;
use App\Services\RequestValidationService;

class PersonController
{
    public function index(): Response
    {
        $persons = DB::fetchAll('SELECT * FROM persons');

        return Response::create($persons);
    }

    public function show(): Response
    {
        $validator = RequestValidationService::create([
            'id' => 'required|integer|exists:persons'
        ]);

        if (!$validator->validate()) {
            return $validator->getResponse();
        }

        $body = $validator->getBody();

        $person = DB::fetch('SELECT * FROM persons WHERE id = ' . $body['id']);

        return Response::create($person);
    }

    public function store(): Response
    {
        $validator = RequestValidationService::create([
            'first_name'    => 'required',
            'last_name'     => 'required',
            'date_of_birth' => 'required|date',
        ]);

        if (!$validator->validate()) {
            return $validator->getResponse();
        }

        $body = $validator->getBody();

        $query = 'INSERT INTO persons (first_name, last_name, date_of_birth)'
            . ' VALUES (:first_name, :last_name, :date_of_birth)';

        DB::query($query, $body);

        return Response::create([
            'id' => DB::lastInsertId()
        ]);
    }

    public function update(): Response
    {
        $validator = RequestValidationService::create([
            'id'            => 'required|integer|exists:persons',
            'first_name'    => 'required',
            'last_name'     => 'required',
            'date_of_birth' => 'required|date'
        ]);

        if (!$validator->validate()) {
            return $validator->getResponse();
        }

        $body = $validator->getBody();

        $query = 'UPDATE persons SET'
            . ' first_name = :first_name,'
            . ' last_name = :last_name,'
            . ' date_of_birth = :date_of_birth'
            . ' WHERE id = :id';

        DB::query($query, $body);

        return Response::create([]);
    }

    public function delete(): Response
    {
        $validator = RequestValidationService::create([
            'id' => 'required|integer|exists:persons'
        ]);

        if (!$validator->validate()) {
            return $validator->getResponse();
        }

        $body = $validator->getBody();

        DB::query('DELETE FROM persons WHERE id = ' . $body['id']);

        return Response::create([]);
    }
}
