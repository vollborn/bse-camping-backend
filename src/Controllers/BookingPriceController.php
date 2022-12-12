<?php

namespace App\Controllers;

use App\Classes\Date;
use App\Classes\DB;
use App\Classes\Response;
use App\Constants\AdditionalCostType;
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

        $booking = $this->getBooking($bookingId);
        $persons = $this->getPersons($bookingId);
        $pitch = $this->getPitch($bookingId);
        $additionalCosts = $this->getAdditionalCosts();

        $price = 0;

        $days = Date::diffInDays($booking['start_at'], $booking['end_at']) + 1;
        $price += $days * $pitch['price_per_day'];

        $adults = $this->getAdultCount($booking, $persons);
        $children = $this->getChildrenCount($booking, $persons);

        foreach ($additionalCosts as $additionalCost) {
            switch ($additionalCost['additional_cost_type_id']) {
                case AdditionalCostType::CHILDREN:
                    $price += $additionalCost['price'] * $children;
                    break;
                case AdditionalCostType::ADULT:
                    $price += $additionalCost['price'] * $adults;
                    break;
                case AdditionalCostType::PET:
                    $price += $additionalCost['price'] * $booking['pet_count'] * $days;
                    break;
                case AdditionalCostType::ELECTRICITY:
                    if ($booking['has_electricity']) {
                        $price += $additionalCost['price'] * $days;
                    }
                    break;
            }
        }

        return Response::create([
            'price' => round($price, 2)
        ]);
    }

    private function getBooking(int $bookingId): array
    {
        return DB::fetch("SELECT * FROM bookings WHERE id = $bookingId");
    }

    private function getPersons(int $bookingId): array
    {
        return DB::fetchAll(
            "SELECT * FROM persons 
            JOIN booking_person bp on persons.id = bp.person_id
            WHERE bp.booking_id = $bookingId"
        );
    }

    private function getPitch(int $bookingId): array
    {
        return DB::fetch(
            "SELECT * FROM pitches
            JOIN bookings b on pitches.id = b.pitch_id
            WHERE b.id = $bookingId"
        );
    }

    private function getAdditionalCosts(): array
    {
        return DB::fetchAll('SELECT * FROM additional_costs');
    }

    private function getAdultCount(array $booking, array $persons): int
    {
        return count(array_filter($persons, static function ($person) use ($booking) {
            try {
                return Date::diffInYears($booking['start_at'], $person['date_of_birth']) >= 13;
            } catch (Exception) {
                return false;
            }
        }));
    }

    private function getChildrenCount(array $booking, array $persons): int
    {
        return count(array_filter($persons, static function ($person) use ($booking) {
            try {
                return Date::diffInYears($booking['start_at'], $person['date_of_birth']) < 13;
            } catch (Exception) {
                return false;
            }
        }));
    }
}