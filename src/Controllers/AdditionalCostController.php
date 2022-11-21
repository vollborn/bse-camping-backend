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
            'additional_cost_type_id' => 'required|integer|exists:additional_cost_types',
            'display_name'            => 'required',
            'price'                   => 'required|numeric'
        ]);

        if (!$validator->validate()) {
            return $validator->getResponse();
        }

        $body = $validator->getBody();

        $query = 'INSERT INTO additional_costs (additional_cost_type_id, display_name, price)'
            . ' VALUES (:additional_cost_type_id, :display_name, :price)';

        DB::query($query, $body);

        return Response::create([
            'id' => DB::lastInsertId()
        ]);
    }

    public function update(): Response
    {
        $validator = RequestValidationService::create([
            'id'                      => 'required|integer|exists:additional_costs',
            'additional_cost_type_id' => 'required|integer|exists:additional_cost_types',
            'display_name'            => 'required',
            'price'                   => 'required|numeric'
        ]);

        if (!$validator->validate()) {
            return $validator->getResponse();
        }

        $body = $validator->getBody();

        $query = 'UPDATE additional_costs SET'
            . ' additional_cost_type_id = :additional_cost_type_id,'
            . ' display_name = :display_name,'
            . ' price = :price'
            . ' WHERE id = :id';

        DB::query($query, $body);

        return Response::create([]);
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

        DB::query('DELETE FROM additional_costs WHERE id = ' . $body['id']);

        return Response::create([]);
    }
}
