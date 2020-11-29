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
        );


        //delete -> this is is too heavy
        // foreach($standings['results'] as $key => $results) {

        //     $jumpers[] = $results['name'];

        //     $obj = new Jumper($results['name'], $id_tournament);

        //     $standings['results'][$key]['stats'] = $obj->stats;

        // }        

        //dd($standings['results']);

        $data['tournament']['stats'] = Tournament::getStats($id_tournament);


        return $data;

    }


   

}


