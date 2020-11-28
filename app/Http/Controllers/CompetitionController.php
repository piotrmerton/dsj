<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\Tournament;
use App\Models\Standings;

class CompetitionController extends Controller
{


    public function display($id_tournament, $id_competition)
    {

        $competition = Competition::loadCompetition($id_tournament, $id_competition);
        $tournament_standings = Standings::loadSingleStandings($id_tournament, $id_competition);

        //dd($tournament_standings);

        return view('competition', 
            [
            	'competition' => $competition,
            	'tournament_standings' => $tournament_standings
            ]
        );
    }
}