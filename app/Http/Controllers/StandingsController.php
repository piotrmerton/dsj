<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Standings;
use App\Models\Tournament;
use App\Models\Jumper;
use App\Breadcrumbs;

class StandingsController extends Controller
{


    public function display($id_tournament, $id_competition)
    {

        $data = Standings::loadSingleStandings($id_tournament, $id_competition, true, true);

        $breadcrumbs = new Breadcrumbs();

        //dd($data);

        return view('standings', 
            [
            	'breadcrumbs' => $breadcrumbs->get(),
            	'data' => $data
            ]
        );
    }
}