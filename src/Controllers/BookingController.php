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
            'has_pets'    => 'required|boolean',
            'persons'     => 'required|array',
            'persons.*'   => 'required|integer|exists:persons'
        ]);

        if (!$validator->validate()) {
            return $validator->getResponse();
        }

        $body = $validator->getBody();

        $query = 'INSERT INTO bookings (customer_id, pitch_id, start_at, end_at, has_pets)'
            . ' VALUES (:customer_id, :pitch_id, :start_at, :end_at, :has_pets)';

        DB::query($query, [
            'customer_id' => $body['customer_id'],
            'pitch_id'    => $body['pitch_id'],
            'start_at'    => $body['start_at'],
            'end_at'      => $body['end_at'],
            'has_pets'    => $body['has_pets'],
        ]);

        $id = DB::lastInsertId();
        $this->addBookingPersons($id, $body['persons']);

        return Response::create([
            'id' => $id
        ]);
    }

    public function update(): Response
    {
        $validator = RequestValidationService::create([
            'id'          => 'required|integer|exists:bookings',
            'customer_id' => 'required|integer|exists:customers',
            'pitch_id'    => 'required|integer|exists:pitches',
            'start_at'    => 'required|date',
            'end_at'      => 'required|date',
            'has_pets'    => 'required|boolean',
            'persons'     => 'required|array',
            'persons.*'   => 'required|integer|exists:persons'
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

        DB::query($query, [
            'id'          => $body['id'],
            'customer_id' => $body['customer_id'],
            'pitch_id'    => $body['pitch_id'],
            'start_at'    => $body['start_at'],
            'end_at'      => $body['end_at'],
            'has_pets'    => $body['has_pets'],
        ]);

        DB::query('DELETE FROM booking_person WHERE booking_id = :id', [
            'id' => $body['id']
        ]);

        $this->addBookingPersons($body['id'], $body['persons']);

        return Response::create([]);
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

        DB::query('DELETE FROM bookings WHERE id = ' . $body['id']);

        return Response::create([]);
    }

    private function addBookingPersons(int $id, array $persons)
    {
        $query = 'INSERT INTO booking_person (booking_id, person_id)'
            . ' VALUES (:booking_id, :person_id)';

        foreach ($persons as $personId) {
            DB::query($query, [
                'booking_id' => $id,
                'person_id'  => $personId
            ]);
        }
    }
}
