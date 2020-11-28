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

        $breadcrumbs = new Breadcrumbs($tournament['name'], route('tournament', $tournament['id']));

        $latest_competition = end($tournament['calendar']);

        $standings = Standings::loadSingleStandings($id_tournament, $latest_competition['id']);

        //dd($breadcrumbs);

        return view('tournament', 
            [
                'breadcrumbs' => $breadcrumbs->get(),
            	'tournament' => $tournament,
            	'standings' => $standings,
        	]
        );
    }



}