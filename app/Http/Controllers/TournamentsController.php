<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tournament;

class TournamentsController extends Controller
{


    public function display()
    {

        $tournaments = Tournament::loadTournaments();

        return view('tournaments', 
            ['tournaments' => $tournaments]
        );
    }

}