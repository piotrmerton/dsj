<?php

namespace App\Models;

use App\Models\DsjData;
use Symfony\Component\Yaml\Yaml; //https://stackoverflow.com/a/54129307


class Tournament {


    public $id_tournament;
    public $date;

    public function __construct($id_tournament) {

    }


	/**
	 * load all available toutrnaments by reading dir conttents
	 */
	public static function loadTournaments() {

		$path = DsjData::$dir_tournaments;
        $files = array();

        if ($handle = opendir($path)) {

            /* loop over the directory. */
            while (false !== ($item = readdir($handle))) {
                if ($item != "." && $item != ".." && $item != "index.php") {
                    $data = self::loadTournamentMeta($item);
                    $files[] = $data;
                }

            }

            closedir($handle);

        }


        //sort by id https://stackoverflow.com/a/2699159
        usort($files, function($a, $b) {
            return $b['date_start'] <=> $a['date_start'];
        });         

		return $files;


	}


    public static function loadTournament($id_tournament, $results = false) : array {

        $tournament_data = self::loadTournamentMeta($id_tournament);
        $tournament_data['calendar'] = self::loadTournamentCompetitions($id_tournament, $results);

        return $tournament_data;

    }

    public static function loadTournamentMeta($id_tournament) : array {

        $path = DsjData::$dir_tournaments.'/'.$id_tournament;

        $file = file_get_contents($path . '/'. 'data.yml');

        $tournament_meta = Yaml::parse($file);
        $tournament_meta['id'] = $id_tournament;
        $tournament_meta['url'] = route('tournament', array( 'id_tournament' => $id_tournament));

        return $tournament_meta;

    }

    public static function loadTournamentCompetitions($id_tournament, $results = false) : array {

        $path = DsjData::$dir_tournaments.'/'.$id_tournament.'/competitions';

        if ($handle = opendir($path)) {

            /* loop over the directory. */
            while (false !== ($item = readdir($handle))) {
                if ($item != "." && $item != ".." && $item != "index.php") {
                    

                    // load DSJ4 stats file 
                    $file = file($path .'/'. $item);

                    $competition_data = DsjData::parseDsjStatHeader($file);
                    $competition_data['id'] = str_replace('.txt', '', $item);

                    if( $results ) {
                    	$competition_data['results'] = DsjData::parseDsjStatResults($file, $competition_data['type']);
                    }

                    $tournament_comps[] = $competition_data;

                }

            }

            closedir($handle);

        }

        //sort by id https://stackoverflow.com/a/2699159
		usort($tournament_comps, function($a, $b) {
		    return $a['id'] <=> $b['id'];
		});        

        return $tournament_comps;

    }

    /** load all Tournament standings **/
    public static function loadTournamentStandings($id_tournament) : array {

        $path = DsjData::$dir_tournaments.'/'.$id_tournament.'/standings';

        if ($handle = opendir($path)) {

            /* loop over the directory. */
            while (false !== ($item = readdir($handle))) {
                if ($item != "." && $item != ".." && $item != "index.php") {
                    

                    // load DSJ4 stats file 
                    $file = file($path .'/'. $item);

                    $standings = DsjData::parseDsjStatStandings($file);
                    $id_competition = str_replace('.txt', '', $item);


                    $standings_history[] = array(
                        'standings' => $standings,
                        'id_competition' => $id_competition,
                    );


                }

            }

            closedir($handle);

        }

        //sort by id https://stackoverflow.com/a/2699159
        usort($standings_history, function($a, $b) {
            return $a['id_competition'] <=> $b['id_competition'];
        });        

        return $standings_history;

    }     

}