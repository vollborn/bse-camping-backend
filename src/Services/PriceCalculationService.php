<?php

namespace App\Services;

use App\Classes\Date;
use App\Classes\DB;
use App\Constants\AdditionalCostType;
use Exception;
use function array_filter;
use function count;
use function round;

class PriceCalculationService
{
    private array $persons;
    private array $additionalCosts;
    private array $pitch;

    private int $adultCount;
    private int $childrenCount;
    private int $daysCount;

    public function __construct(private array $booking)
    {
    }

    /**
     * @throws Exception
     */
    public function get(): float
    {
        $this->loadPersons();
        $this->loadAdditionalCosts();
        $this->loadPitch();

        $this->calculatePersonTypesCount();
        $this->calculateDaysCount();

        return $this->calculateTotalPrice();
    }

    private function loadPersons(): void
    {
        $this->persons = DB::fetchAll(
            "SELECT * FROM persons 
            JOIN booking_person bp on persons.id = bp.person_id
            WHERE bp.booking_id = " . $this->booking['id']
        );
    }

    private function loadPitch(): void
    {
        $this->pitch = DB::fetch(
            "SELECT * FROM pitches
            JOIN bookings b on pitches.id = b.pitch_id
            WHERE b.id = " . $this->booking['id']
        );
    }

    private function loadAdditionalCosts(): void
    {
        $this->additionalCosts = DB::fetchAll(
            "SELECT * FROM additional_costs 
            JOIN additional_cost_booking acb on additional_costs.id = acb.additional_cost_id
            WHERE acb.booking_id = " . $this->booking['id']
        );
    }

    private function calculatePersonTypesCount(): void
    {
        $this->adultCount = count(array_filter($this->persons, function ($person) {
            try {
                return Date::diffInYears($this->booking['start_at'], $person['date_of_birth']) >= 13;
            } catch (Exception) {
                return false;
            }
        }));

        $this->childrenCount = count($this->persons) - $this->adultCount;
    }

    /**
     * @throws Exception
     */
    private function calculateDaysCount(): void
    {
        $this->daysCount = Date::diffInDays($this->booking['start_at'], $this->booking['end_at']) + 1;
    }

    private function calculateTotalPrice(): float
    {
        $price = $this->daysCount * $this->pitch['price_per_day'];

        foreach ($this->additionalCosts as $additionalCost) {
            $price = $price + ($this->getAdditionalCostPrice($additionalCost) * $additionalCost['amount']);
        }

        return round($price, 2);
    }

    private function getAdditionalCostPrice(array $additionalCost): float
    {
        /** @noinspection PhpSwitchCanBeReplacedWithMatchExpressionInspection */

        switch ($additionalCost['additional_cost_type_id']) {
            case AdditionalCostType::ONCE:
                return $additionalCost['price'];
            case AdditionalCostType::GUEST_ONCE:
                return $additionalCost['price'] * ($this->adultCount + $this->childrenCount);
            case AdditionalCostType::ADULT_ONCE:
                return $additionalCost['price'] * $this->adultCount;
            case AdditionalCostType::CHILDREN_ONCE:
                return $additionalCost['price'] * $this->childrenCount;
            case AdditionalCostType::PET_ONCE:
                return $additionalCost['price'] * $this->booking['pet_count'];

            case AdditionalCostType::DAILY:
                return $additionalCost['price'] * $this->daysCount;
            case AdditionalCostType::GUEST_DAILY:
                return $additionalCost['price'] * ($this->adultCount + $this->childrenCount) * $this->daysCount;
            case AdditionalCostType::ADULT_DAILY:
                return $additionalCost['price'] * $this->adultCount * $this->daysCount;
            case AdditionalCostType::CHILDREN_DAILY:
                return $additionalCost['price'] * $this->childrenCount * $this->daysCount;
            case AdditionalCostType::PET_DAILY:
                return $additionalCost['price'] * $this->booking['pet_count'] * $this->daysCount;
        }

        return 0;
    }
}