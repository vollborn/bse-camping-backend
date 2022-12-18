<?php

namespace App\Controllers;

use App\Classes\DB;
use App\Classes\Response;
use App\Services\RequestValidationService;
use Exception;

class BookingAdditionalCostController
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

        $query = 'SELECT * FROM additional_costs
            JOIN additional_cost_booking acb on additional_costs.id = acb.additional_cost_id
            WHERE acb.booking_id = :booking_id';

        $additionalCosts = DB::fetchAll($query, $body);

        return Response::create($additionalCosts);
    }

    /**
     * @throws Exception
     */
    public function store(): Response
    {
        $validator = RequestValidationService::create([
            'booking_id'         => 'required|integer',
            'additional_cost_id' => 'required|integer',
            'amount'             => 'required|integer'
        ]);

        if (!$validator->validate()) {
            return $validator->getResponse();
        }

        $body = $validator->getBody();

        DB::query('DELETE FROM additional_cost_booking WHERE booking_id = :booking_id AND additional_cost_id = :additional_cost_id', [
            'booking_id' => $body['booking_id'],
            'additional_cost_id' => $body['additional_cost_id']
        ]);

        $query = 'INSERT INTO additional_cost_booking (booking_id, additional_cost_id, amount)
            VALUES (:booking_id, :additional_cost_id, :amount)';

        DB::query($query, $body);

        return Response::create();
    }
}
