<?php

namespace App\Models;

use App\Models\DsjData;
use App\Models\Tournament;


class Standings {


    public static function loadSingleStandings($id_tournament, $id_competition) : array {

        $path = DsjData::$dir_tournaments.'/'.$id_tournament;

        // load DSJ4 stats file 
        $file = file($path.'/standings/'.$id_competition.'.txt');

        $standings = DsjData::parseDsjStatStandings($file);

        $tournament_meta = Tournament::loadTournamentMeta($id_tournament);

        $data = array(
        	'tournament' => $tournament_meta,
        	'standings' => $standings,
        );

        return $data;

    }


   

}


