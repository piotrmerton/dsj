<?php

namespace App\Models;

use App\Models\DsjData;
use App\Models\Tournament;

class Competition {

	public $date;
	public $city;
	public $hs;
	public $results;

	public function __construct($id_tournament, $id_competition) {

	}

    /**
     * load single competition
     */
    public static function loadCompetition($id_tournament, $id_competition) : array {

        $path = DsjData::$dir_tournaments.'/'.$id_tournament;

        // load DSJ4 stats file 
        $file = file($path.'/competitions/'.$id_competition.'.txt');

        $header = DsjData::parseDsjStatHeader($file);

        $results = DsjData::parseDsjStatResults($file, $header['type']);

        $tournament_meta = Tournament::loadTournamentMeta($id_tournament);

        $competition_data = array_merge(
        	$header, 
        	array(
        		'tournament' => $tournament_meta,
        		'results' => $results,
        	),
        );

        return $competition_data;

    }

}


