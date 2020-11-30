<?php

namespace App\Models;

use App\Models\DsjData;
use App\Models\Tournament;

class Competition {

    public $id;
    public $name;
	public $date;
	public $city;
	public $hs;
	public $results;

	public function __construct($id_tournament, $id_competition) {

        $competition = self::loadCompetition($id_tournament, $id_competition);

        //TO DO: iterate through keys and assign programatically
        $this->id($competition['id']);
        $this->name($competition['name']);
        $this->results($competition['results']);

	}

    /**
     * load single competition meta and results
     */
    public static function loadCompetition($id_tournament, $id_competition, $header = true, $load_tournament_meta = true, $load_qualifications = true) : array {

        $path = DsjData::$dir_tournaments.'/'.$id_tournament;
        $file_path = $path.'/competitions/'.$id_competition.'.txt';
        
        if(!file_exists($file_path)) die( 'Error: competition stats does not exist' );

        // load DSJ4 stats file 
        $file = file($file_path);

        if($header) {
            $header = DsjData::parseDsjStatHeader($file);
            
            $competition_data = array_merge(
                $header, 
                array(
                    'results' => DsjData::parseDsjStatResults($file, $header['type']),
                ),
            );
        } else {
            $competition_data = array(
                'results' => DsjData::parseDsjStatResults($file),
            );
        }

        if($load_tournament_meta) {
            $competition_data['tournament'] = Tournament::loadTournamentMeta($id_tournament);
        }
        if($load_qualifications) {
            $competition_data['qualifications'] = self::loadQualificationsResults($id_tournament, $id_competition);
        }

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


