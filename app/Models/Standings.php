<?php

namespace App\Models;

use App\Models\DsjData;
use App\Models\Tournament;


class Standings {


    public static function loadSingleStandings($id_tournament, $id_competition, $compare = true) : array {

        $path = DsjData::$dir_tournaments.'/'.$id_tournament;

        // load DSJ4 stats file 
        $file = file($path.'/standings/'.$id_competition.'.txt');

        $standings = DsjData::parseDsjStatStandingsHeader($file);
        $standings['results'] = DsjData::parseDsjStatStandings($file, $id_tournament, $id_competition, $compare);

        $tournament_meta = Tournament::loadTournamentMeta($id_tournament);

        $data = array(
        	'tournament' => $tournament_meta,
        	'standings' => $standings,
            'latest_competition_id' => $id_competition,
        );


        //WARNING: this can be potentially significant performance bottleneck
        $data['tournament']['stats'] = Tournament::getStats($id_tournament, $id_competition);

        return $data;

    }


   

}


