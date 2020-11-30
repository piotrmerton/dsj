<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ranking;
use App\Models\Tournament;
use App\Breadcrumbs;

class RankingController extends Controller
{


    public function display($id_tournament, $id_ranking, $stage = false)
    {

        if( $stage ) {
            $ranking = Ranking::loadRanking($id_tournament, $id_ranking, $stage);
        } else {
            $ranking = Ranking::loadRanking($id_tournament, $id_ranking);
        }
        
        $tournament = Tournament::loadTournamentMeta($id_tournament);

        $breadcrumbs = new Breadcrumbs( $tournament['name'], route('tournament', array($id_tournament)) );
        $breadcrumbs->add( $ranking['name'], route('ranking', array($id_tournament, $id_ranking)) );

        //dd($ranking);

        return view('ranking', 
            [
                'breadcrumbs' => $breadcrumbs->get(),
                'ranking' => $ranking,
                'tournament' => $tournament,
            ]
        );
    }
}