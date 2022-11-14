<?php

namespace App\Controllers;

use App\Classes\DB;
use App\Classes\Response;
use App\Services\RequestValidationService;

class BookingController
{
    public function index(): Response
    {
        $bookings = DB::fetchAll('SELECT * FROM bookings');

        return Response::create($bookings);
    }

    public function show(): Response
    {
        $validator = RequestValidationService::create([
            'id' => 'required|integer|exists:bookings'
        ]);

        if (!$validator->validate()) {
            return $validator->getResponse();
        }

        $body = $validator->getBody();

        $booking = DB::fetch('SELECT * FROM bookings WHERE id = ' . $body['id']);

        return Response::create($booking);
    }

    public function store(): Response
    {
        $validator = RequestValidationService::create([
            'customer_id' => 'required|numeric|exists:customers',
            'pitch_id'    => 'required|numeric|exists:pitches',
            'start_at'    => 'required|date',
            'end_at'      => 'required|date',
            'has_pets'    => 'required|boolean'
        ]);

        if (!$validator->validate()) {
            return $validator->getResponse();
        }

        $body = $validator->getBody();

        $query = 'INSERT INTO bookings (customer_id, pitch_id, start_at, end_at, has_pets)'
            . ' VALUES (:customer_id, :pitch_id, :start_at, :end_at, :has_pets)';

        $success = DB::query($query, $body);

        return Response::create([], $success ? 200 : 500);
    }

    public function update(): Response
    {
        $validator = RequestValidationService::create([
            'id'          => 'required|integer|exists:bookings',
            'customer_id' => 'required|numeric|exists:customers',
            'pitch_id'    => 'required|numeric|exists:pitches',
            'start_at'    => 'required|date',
            'end_at'      => 'required|date',
            'has_pets'    => 'required|boolean'
        ]);

        if (!$validator->validate()) {
            return $validator->getResponse();
        }

        $body = $validator->getBody();

        $query = 'UPDATE bookings SET'
            . ' customer_id = :customer_id,'
            . ' pitch_id = :pitch_id,'
            . ' start_at = :start_at,'
            . ' end_at = :end_at,'
            . ' has_pets = :has_pets'
            . ' WHERE id = :id';

        $success = DB::query($query, $body);

        return Response::create([], $success ? 200 : 500);
    }

    public function delete(): Response
    {
        $validator = RequestValidationService::create([
            'id' => 'required|integer|exists:bookings'
        ]);

        if (!$validator->validate()) {
            return $validator->getResponse();
        }

        $body = $validator->getBody();

        $success = DB::query('DELETE FROM bookings WHERE id = ' . $body['id']);

        return Response::create([], $success ? 200 : 500);
    }
}
