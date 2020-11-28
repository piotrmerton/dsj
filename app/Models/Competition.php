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
     * load single competition meta and results
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
                'qualifications' => self::loadQualificationsResults($id_tournament, $id_competition),
        	),
        );

        return $competition_data;

    }


    /**
     * load qualification standings
     * TO DO: create and move to Qualification Model?
     */
    public static function loadQualificationsResults($id_tournament, $id_competition) : array {

        $path = DsjData::$dir_tournaments.'/'.$id_tournament;

        // load DSJ4 stats file 
        $file = file($path.'/qualifications/'.$id_competition.'.txt');

        $results = DsjData::parseDsjStatResults($file, 'qualifications');

        return $results;

    }    

}


