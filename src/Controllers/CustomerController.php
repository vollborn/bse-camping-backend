<?php

namespace App\Controllers;

use App\Classes\DB;
use App\Classes\Response;
use App\Services\RequestValidationService;

class CustomerController
{
    public function index(): Response
    {
        $customers = DB::fetchAll('SELECT * FROM customers');

        return Response::create($customers);
    }

    public function show(): Response
    {
        $validator = RequestValidationService::create([
            'id' => 'required|integer|exists:customers'
        ]);

        if (!$validator->validate()) {
            return $validator->getResponse();
        }

        $body = $validator->getBody();

        $customer = DB::fetch('SELECT * FROM customers WHERE id = ' . $body['id']);

        return Response::create($customer);
    }

    public function store(): Response
    {
        $validator = RequestValidationService::create([
            'first_name'    => 'required',
            'last_name'     => 'required',
            'city'          => 'required',
            'postcode'      => 'required',
            'street'        => 'required',
            'country_id'    => 'required|integer|exists:countries',
            'phone'         => 'required',
            'email'         => 'required',
            'date_of_birth' => 'required|date'
        ]);

        if (!$validator->validate()) {
            return $validator->getResponse();
        }

        $body = $validator->getBody();
        $query = 'INSERT INTO customers (first_name, last_name, city, postcode, street, country_id, phone, email, date_of_birth)'
            . ' VALUES (:first_name, :last_name, :city, :postcode, :street, :country_id, :phone, :email, :date_of_birth)';

        $success = DB::query($query, $body);

        return Response::create([], $success ? 200 : 500);
    }

    public function update(): Response
    {
        $validator = RequestValidationService::create([
            'id'            => 'required|integer|exists:customers',
            'first_name'    => 'required',
            'last_name'     => 'required',
            'city'          => 'required',
            'postcode'      => 'required',
            'street'        => 'required',
            'country_id'    => 'required|integer|exists:countries',
            'phone'         => 'required',
            'email'         => 'required',
            'date_of_birth' => 'required|date'
        ]);

        if (!$validator->validate()) {
            return $validator->getResponse();
        }

        $body = $validator->getBody();
        $query = 'UPDATE customers SET'
            . ' first_name = :first_name,'
            . ' last_name = :last_name,'
            . ' city = :city,'
            . ' postcode = :postcode,'
            . ' street = :street,'
            . ' country_id = :country_id,'
            . ' phone = :phone,'
            . ' email = :email,'
            . ' date_of_birth = :date_of_birth'
            . ' WHERE id = :id';

        $success = DB::query($query, $body);

        return Response::create([], $success ? 200 : 500);
    }

    public function delete(): Response
    {
        $validator = RequestValidationService::create([
            'id' => 'required|integer|exists:customers'
        ]);

        if (!$validator->validate()) {
            return $validator->getResponse();
        }

        $body = $validator->getBody();

        $success = DB::query('DELETE FROM customers WHERE id = ' . $body['id']);

        return Response::create([], $success ? 200 : 500);
    }
}
