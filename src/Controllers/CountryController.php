<?php

namespace App\Controllers;

use App\Classes\DB;
use App\Classes\Response;

class CountryController
{
    public function index(): Response
    {
        $pitches = DB::fetchAll('SELECT * FROM countries');

        return Response::create($pitches);
    }
}
