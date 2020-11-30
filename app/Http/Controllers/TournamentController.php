<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tournament;
use App\Models\Standings;
use App\Breadcrumbs;

class TournamentController extends Controller
{

    public function display($id_tournament)
    {

        
        $tournament = Tournament::loadTournament($id_tournament);

        $breadcrumbs = new Breadcrumbs($tournament['name'], false);

        $standings = Standings::loadSingleStandings($id_tournament, $tournament['latest_competition_id']);

        //dd($standings);

        return view('tournament', 
            [
                'breadcrumbs' => $breadcrumbs->get(),
            	'tournament' => $tournament,
            	'standings' => $standings,
        	]
        );
    }



}