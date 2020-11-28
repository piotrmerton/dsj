<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Models\Tournament;
use App\Models\Standings;
use App\Breadcrumbs;

class CompetitionController extends Controller
{


    public function display($id_tournament, $id_competition)
    {

        $competition = Competition::loadCompetition($id_tournament, $id_competition);
        
        $tournament_standings = Standings::loadSingleStandings($id_tournament, $id_competition);

        $breadcrumbs = new Breadcrumbs();
        $breadcrumbs->add( $tournament_standings['tournament']['name'], route('tournament', $id_tournament) );
        $breadcrumbs->add( $competition['name'], false);

        //dd($tournament_standings);

        return view('competition', 
            [
                'breadcrumbs' => $breadcrumbs->get(),
            	'competition' => $competition,
            	'tournament_standings' => $tournament_standings
            ]
        );
    }
}