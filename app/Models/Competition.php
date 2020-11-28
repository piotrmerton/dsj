<?php

namespace App\Models;

use App\Models\Data;
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

        $path = Data::$dir_tournaments.'/'.$id_tournament;

        // load DSJ4 stats file 
        $file = file($path.'/competitions/'.$id_competition.'.txt');

        $header = Data::parseDsjStatHeader($file);

        $results = Data::parseDsjStatResults($file, $header['type']);

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


