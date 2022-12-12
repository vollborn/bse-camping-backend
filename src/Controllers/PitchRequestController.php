<?php

namespace App\Controllers;

use App\Classes\Body;
use App\Classes\DB;
use App\Classes\Response;
use App\Services\RequestValidationService;

class PitchRequestController
{
    public function index(): Response
    {
        $validator = RequestValidationService::create([
            'input_start'        => 'required|date',
            'input_end'          => 'required|date'
        ]);

        if (!$validator->validate()) {
            return $validator->getResponse();
        }

        $body = $validator->getBody();

        $pitches = DB::fetchAll('SELECT * FROM pitches WHERE id NOT IN (SELECT pitch_id FROM bookings WHERE start_at < :input_end AND end_at > :input_start)', $body);

        return Response::create($pitches);
    }
}
