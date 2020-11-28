<?php

namespace App\Models;

use App\Models\Data;
use App\Models\Tournament;


class Standings {


    public static function loadSingleStandings($id_tournament, $id_competition) : array {

        $path = Data::$dir_tournaments.'/'.$id_tournament;

        // load DSJ4 stats file 
        $file = file($path.'/standings/'.$id_competition.'.txt');

        $standings = Data::parseDsjStatStandings($file);

        $tournament_meta = Tournament::loadTournamentMeta($id_tournament);

        $data = array(
        	'tournament' => $tournament_meta,
        	'standings' => $standings,
        );

        return $data;

    }


   

}


