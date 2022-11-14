<?php

namespace App\Controllers;

use App\Classes\DB;
use App\Classes\Response;
use App\Services\RequestValidationService;

class PitchController
{
    public function index(): Response
    {
        $pitches = DB::fetchAll('SELECT * FROM pitches');

        return Response::create($pitches);
    }

    public function show(): Response
    {
        $validator = RequestValidationService::create([
            'id' => 'required|integer|exists:pitches'
        ]);

        if (!$validator->validate()) {
            return $validator->getResponse();
        }

        $body = $validator->getBody();

        $pitch = DB::fetch('SELECT * FROM pitches WHERE id = ' . $body['id']);

        return Response::create($pitch);
    }

    public function store(): Response
    {
        $validator = RequestValidationService::create([
            'field_number'  => 'required',
            'width'         => 'required|numeric',
            'height'        => 'required|numeric',
            'price_per_day' => 'required|numeric'
        ]);

        if (!$validator->validate()) {
            return $validator->getResponse();
        }

        $body = $validator->getBody();

        $query = 'INSERT INTO pitches (field_number, width, height, price_per_day)'
            . ' VALUES (:field_number, :width, :height, :price_per_day)';

        $success = DB::query($query, $body);

        return Response::create([], $success ? 200 : 500);
    }

    public function update(): Response
    {
        $validator = RequestValidationService::create([
            'id'            => 'required|integer|exists:pitches',
            'field_number'  => 'required',
            'width'         => 'required|numeric',
            'height'        => 'required|numeric',
            'price_per_day' => 'required|numeric'
        ]);

        if (!$validator->validate()) {
            return $validator->getResponse();
        }

        $body = $validator->getBody();

        $query = 'UPDATE pitches SET'
            . ' field_number = :field_number,'
            . ' width = :width,'
            . ' height = :height,'
            . ' price_per_day = :price_per_day'
            . ' WHERE id = :id';

        $success = DB::query($query, $body);

        return Response::create([], $success ? 200 : 500);
    }

    public function delete(): Response
    {
        $validator = RequestValidationService::create([
            'id' => 'required|integer|exists:pitches'
        ]);

        if (!$validator->validate()) {
            return $validator->getResponse();
        }

        $body = $validator->getBody();

        $success = DB::query('DELETE FROM pitches WHERE id = ' . $body['id']);

        return Response::create([], $success ? 200 : 500);
    }
}
