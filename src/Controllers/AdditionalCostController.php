<?php

namespace App\Controllers;

use App\Classes\DB;
use App\Classes\Response;
use App\Services\RequestValidationService;

class AdditionalCostController
{
    public function index(): Response
    {
        $additionalCosts = DB::fetchAll('SELECT * FROM additional_costs');

        return Response::create($additionalCosts);
    }

    public function show(): Response
    {
        $validator = RequestValidationService::create([
            'id' => 'required|integer|exists:additional_costs'
        ]);

        if (!$validator->validate()) {
            return $validator->getResponse();
        }

        $body = $validator->getBody();

        $additionalCost = DB::fetch('SELECT * FROM additional_costs WHERE id = ' . $body['id']);

        return Response::create($additionalCost);
    }

    public function store(): Response
    {
        $validator = RequestValidationService::create([
            'display_name' => 'required',
            'price'        => 'required|numeric'
        ]);

        if (!$validator->validate()) {
            return $validator->getResponse();
        }

        $body = $validator->getBody();

        $query = 'INSERT INTO additional_costs (display_name, price)'
            . ' VALUES (:display_name, :price)';

        $success = DB::query($query, $body);

        return Response::create([], $success ? 200 : 500);
    }

    public function update(): Response
    {
        $validator = RequestValidationService::create([
            'id'           => 'required|integer|exists:additional_costs',
            'display_name' => 'required',
            'price'        => 'required|numeric'
        ]);

        if (!$validator->validate()) {
            return $validator->getResponse();
        }

        $body = $validator->getBody();

        $query = 'UPDATE additional_costs SET'
            . ' display_name = :display_name,'
            . ' price = :price'
            . ' WHERE id = :id';

        $success = DB::query($query, $body);

        return Response::create([], $success ? 200 : 500);
    }

    public function delete(): Response
    {
        $validator = RequestValidationService::create([
            'id' => 'required|integer|exists:additional_costs'
        ]);

        if (!$validator->validate()) {
            return $validator->getResponse();
        }

        $body = $validator->getBody();

        $success = DB::query('DELETE FROM additional_costs WHERE id = ' . $body['id']);

        return Response::create([], $success ? 200 : 500);
    }
}
