<?php

namespace App\Models;

use App\Models\DsjData;
use App\Models\Hill;
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

        $tournament_meta = Yaml::parseFile($path . '/'. 'data.yml');
        
        $tournament_meta['id'] = $id_tournament;
        $tournament_meta['url'] = route('tournament', array( 'id_tournament' => $id_tournament));

        return $tournament_meta;

    }

    /**
     * Load all Tournament competitions files and decide how to parse it. Sort them by ID. Reads whole /competitions/ dir.
     * @param $id_tournament
     * @param $results - parse and return Stat results
     * @param $header -- parse and return Stat header (meta info: Competition name, country, hill size)
     **/
    public static function loadTournamentCompetitions($id_tournament, bool $results = false, bool $header = true) : array {

        $path = DsjData::$dir_tournaments.'/'.$id_tournament.'/competitions';

        if ($handle = opendir($path)) {

            /* loop over the directory. */
            while (false !== ($item = readdir($handle))) {
                if ($item != "." && $item != ".." && $item != "index.php") {
                    
                    // load DSJ4 stats file 
                    $file = file($path .'/'. $item);

                    if($header) $competition_data = DsjData::parseDsjStatHeader($file);
                    $competition_data['id'] = str_replace('.txt', '', $item);

                    if( $results ) {
                    	$competition_data['results'] = DsjData::parseDsjStatResults($file);
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

    /**
     * Load all Tournament competitions files to and parse results
     * This is similar to Tournament::loadTournamentCompetitions but more lightweight, since we don't parse Stats headers. Probably both methods should be merged and use arguments as settings 
     * @param $id_tournament
     **/    
    public static function loadTournamentCompetitionsResults($id_tournament) : array {
        
        $path = DsjData::$dir_tournaments.'/'.$id_tournament.'/competitions';

        if ($handle = opendir($path)) {

            /* loop over the directory. */
            while (false !== ($item = readdir($handle))) {
                if ($item != "." && $item != ".." && $item != "index.php") {
                    
                    // load DSJ4 stats file 
                    $file = file($path .'/'. $item);

                    $competition_data['id'] = str_replace('.txt', '', $item);
                    $competition_data['results'] = DsjData::parseDsjStatResults($file);
                    
                    $tournament_comps[$competition_data['id']] = $competition_data;

                }

            }

            closedir($handle);

        }

        usort($tournament_comps, function($a, $b) {
            return $a['id'] <=> $b['id'];
        });

        return $tournament_comps;

    }

    /**
     * Load all Tournament standings files and sort them by ID. Reads whole /standings/ dir.
     * @param $id_tournament
     **/    
    public static function loadTournamentStandings($id_tournament) : array {

        $path = DsjData::$dir_tournaments.'/'.$id_tournament.'/standings';

        if ($handle = opendir($path)) {

            /* loop over the directory. */
            while (false !== ($item = readdir($handle))) {
                if ($item != "." && $item != ".." && $item != "index.php") {
                    
                    // load DSJ4 stats file 
                    $file = file($path .'/'. $item);

                    $standings = DsjData::parseDsjStatStandings($file, $id_tournament);
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

    /**
     * Get Tournament Stats (who has the most wins, most podiums etc). Load all Tournament competitions files (reads whole /competitions/ dir, but parse only results which is a little bit more lightweight) 
     * TO DO: create and move to Stats Model?
     * @param $id_tournament
     * @param $last_competition_id - get stats only to a certain competition 
     **/    
    public static function getStats($id_tournament, $last_competition_id = false) {

        $competitions = self::loadTournamentCompetitionsResults($id_tournament);

        $stats['final_rounds'] = array();
        $stats['top_three'] = array();
        $stats['wins'] = array();

        //dd($competitions);

        foreach($competitions as $competition) {

            if(isset($last_competition_id) && (int)$competition['id'] > (int)$last_competition_id) break;

            foreach($competition['results'] as $result) {

                $name = $result['name'];

                if( !array_key_exists( $name, $stats['final_rounds'] ) ) {
                    $stats['final_rounds'][$name] = 0;
                }

                if( !array_key_exists( $name, $stats['top_three'] ) ) {
                    $stats['top_three'][$name] = 0;
                }               
                
                if( !array_key_exists( $name, $stats['wins'] ) ) {
                    $stats['wins'][$name] = 0;
                }      

                if($result['real_position'] <= 3) $stats['top_three'][$name]++;
                if($result['real_position'] == 1) $stats['wins'][$name]++;
                if($result['real_position'] <= 30) $stats['final_rounds'][$name]++;

            }   

        }

        array_multisort($stats['final_rounds'], SORT_DESC);
        array_multisort($stats['top_three'], SORT_DESC);
        array_multisort($stats['wins'], SORT_DESC);        

        //dd($stats);

        return $stats;

    } 

}