<?php

namespace App\Controllers;

use App\Classes\DB;
use App\Classes\Response;
use App\Services\RequestValidationService;

class BookingPersonController
{
    public function index(): Response
    {
        $validator = RequestValidationService::create([
            'booking_id' => 'required|integer|exists:bookings'
        ]);

        if (!$validator->validate()) {
            return $validator->getResponse();
        }

        $body = $validator->getBody();

        $query = 'SELECT * FROM persons
            JOIN booking_person bp on persons.id = bp.person_id
            WHERE bp.booking_id = :booking_id';

        $persons = DB::fetchAll($query, $body);

        return Response::create($persons);
    }
}
