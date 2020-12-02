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


    public static function loadTournament($id_tournament, $stats = false) : array {

        $tournament_data = self::loadTournamentMeta($id_tournament);
        $tournament_data['calendar'] = self::getCalendar($tournament_data);
        $tournament_data['latest_competition_id'] = end($tournament_data['calendar'])['id'];

        if($stats) $tournament_data['stats'] = self::getStats($id_tournament);

        return $tournament_data;

    }

    public static function loadTournamentMeta($id_tournament) : array {

        $path = DsjData::$dir_tournaments.'/'.$id_tournament;

        $tournament_meta = Yaml::parseFile($path . '/'. 'data.yml');
        
        $tournament_meta['id'] = $id_tournament;
        $tournament_meta['url'] = route('tournament', array( 'id_tournament' => $id_tournament));

        return $tournament_meta;

    }

    private static function getCalendar($tournament) : array {

        $competitions = self::loadTournamentCompetitions($tournament['id'], false);

        foreach($competitions as $key => $competition) {

            
            foreach($tournament['rankings'] as $ranking) {

                if(in_array($competition['id'], $ranking['competitions'])) {
                   
                    $stage = array_search($competition['id'], $ranking['competitions']);

                    $competitions[$key]['ranking'] = array(
                        'name' => $ranking['name'],
                        'url' => route('ranking', array($tournament['id'], $ranking['id'], $stage+1)),
                    );

                    if(isset($ranking['highlight'])) $competitions[$key]['highlight'] = true;
                    
                    break;
                }

            }

        }

        return $competitions;

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
                    $id_competition = str_replace('.txt', '', $item);
                    $competition_data['id'] = $id_competition;
                    $competition_data['url'] = route('competition', array($id_tournament, $id_competition) );

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
     * This is similar wrapper of Tournament::loadTournamentCompetitions but more lightweight, since we don't parse Stats headers. Probably both methods should be merged and use arguments as settings 
     * @param $id_tournament
     **/    
    public static function loadTournamentCompetitionsResults($id_tournament) : array {

        return self::loadTournamentCompetitions($id_tournament, true, false);
        
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

        $stats['final_round'] = array();
        $stats['top_three'] = array();
        $stats['wins'] = array();
        $stats['number_of_competitions'] = count($competitions);
        $stats['podiums'] = array();

        //dd($competitions);

        foreach($competitions as $competition) {

            if($last_competition_id !== false && (int)$competition['id'] > (int)$last_competition_id) break;

            foreach($competition['results'] as $result) {

                $name = $result['name'];
                $country = $result['country'];
                $real_position = $result['real_position'];

                if($real_position == 1) {
                    if( !array_key_exists( $name, $stats['wins']) ) {
                        $stats['wins'][$name] = array(
                            'name' => $name,
                            'country' => $country,
                            'quantity' => 1,
                        );
                    } else {
                        $stats['wins'][$name]['quantity']++;
                    }
                }

                if($real_position <= 3) {
                    if( !array_key_exists( $name, $stats['top_three']) ) {
                        $stats['top_three'][$name] = array(
                            'name' => $name,
                            'country' => $country,
                            'quantity' => 1,
                            '1' => 0,
                            '2' => 0,
                            '3' => 0,
                        );
                        $stats['top_three'][$name][$real_position]++;
                    } else {
                        $stats['top_three'][$name]['quantity']++;
                        $stats['top_three'][$name][$real_position]++;
                    }

                    $stats['podiums'][$competition['id']][] = array(
                        'real_position' => $real_position,
                        'name' => $name,
                    );

                } 
                
                if($real_position <= 30) {

                    if( !array_key_exists( $name, $stats['final_round']) ) {
                        $stats['final_round'][$name] = array(
                            'name' => $name,
                            'country' => $country,
                            'quantity' => 1,
                        );
                    } else {
                        $stats['final_round'][$name]['quantity']++;
                    }
                }                


            }   

        }

        $quantity  = array_column($stats['wins'], 'quantity');
        array_multisort($quantity, SORT_DESC, $stats['wins']);

        $quantity  = array_column($stats['top_three'], 'quantity');
        array_multisort($quantity, SORT_DESC, $stats['top_three']);
        
        $quantity  = array_column($stats['final_round'], 'quantity');
        array_multisort($quantity, SORT_DESC, $stats['final_round']);        

        //dd($stats['top_three']);

        return $stats;

    } 

}