<?php

namespace App\Controllers;

use App\Classes\DB;
use App\Classes\Response;
use App\Services\PriceCalculationService;
use App\Services\RequestValidationService;
use Exception;

class BookingPriceController
{
    /**
     * @throws Exception
     */
    public function show(): Response
    {
        $validator = RequestValidationService::create([
            'booking_id' => 'required|integer|exists:bookings'
        ]);

        if (!$validator->validate()) {
            return $validator->getResponse();
        }

        $body = $validator->getBody();
        $bookingId = $body['booking_id'];

        $booking = DB::fetch("SELECT * FROM bookings WHERE id = $bookingId");
        $service = new PriceCalculationService($booking);

        return Response::create([
            'price' => $service->get()
        ]);
    }
}