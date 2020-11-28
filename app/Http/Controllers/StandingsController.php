<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Standings;
use App\Models\Tournament;

class StandingsController extends Controller
{


    public function display($id_tournament, $id_competition)
    {

        $data = Standings::loadSingleStandings($id_tournament, $id_competition);

        //dd($data);

        return view('standings', 
            ['data' => $data ]
        );
    }
}