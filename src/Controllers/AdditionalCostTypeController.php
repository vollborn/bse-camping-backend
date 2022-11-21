<?php

namespace App\Controllers;

use App\Classes\DB;
use App\Classes\Response;

class AdditionalCostTypeController
{
    public function index(): Response
    {
        $pitches = DB::fetchAll('SELECT * FROM additional_cost_types');

        return Response::create($pitches);
    }
}
