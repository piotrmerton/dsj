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
        
        $breadcrumbs = new Breadcrumbs();

        //dd($ranking);

        return view('ranking', 
            [
                'breadcrumbs' => $breadcrumbs->get(),
                'ranking' => $ranking,
                'tournament' => Tournament::loadTournamentMeta($id_tournament),
            ]
        );
    }
}