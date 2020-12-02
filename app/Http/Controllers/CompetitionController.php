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
        
        $tournament_standings = Standings::loadSingleStandings($id_tournament, $id_competition, true, true);

        $breadcrumbs = new Breadcrumbs();
        $breadcrumbs->add( $tournament_standings['tournament']['name'], route('tournament', $id_tournament) );
        $breadcrumbs->add( $competition['name'], false);


        // prepare prev/next competitions link for banner_Nav
        $tournament_competitions = Tournament::loadTournamentCompetitions($id_tournament, false);
        $last_competition_id = end($tournament_competitions)['id'];

        $prev_competition_url = $id_competition == 1 ? false : route('competition', array($id_tournament, $id_competition - 1));
        $next_competition_url = $last_competition_id == $id_competition ? false : route('competition', array($id_tournament, $id_competition + 1));


        //dd($tournament_standings);

        return view('competition', 
            [
                'breadcrumbs' => $breadcrumbs->get(),
            	'competition' => $competition,
                'tournament_standings' => $tournament_standings,
                'leader' => Standings::getLeader($id_tournament, $id_competition),
                'prev_competition_url' => $prev_competition_url,
                'next_competition_url' => $next_competition_url,
            ]
        );
    }
}