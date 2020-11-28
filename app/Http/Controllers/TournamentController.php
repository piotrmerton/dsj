<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\Standings;

class TournamentController extends Controller
{

    public function display($id_tournament)
    {

        $tournament = Tournament::loadTournament($id_tournament);

        $latest_competition = end($tournament['calendar']);

        $standings = Standings::loadSingleStandings($id_tournament, $latest_competition['id']);

        //dd($tournament);

        return view('tournament', 
            [
            	'tournament' => $tournament,
            	'standings' => $standings,
        	]
        );
    }

}