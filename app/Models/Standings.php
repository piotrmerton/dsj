<?php

namespace App\Models;

use App\Models\DsjData;
use App\Models\Tournament;


class Standings {


    public static function loadSingleStandings($id_tournament, $id_competition, $compare = true, $stats = false) : array {

        $tournament_meta = Tournament::loadTournamentMeta($id_tournament);


        $path = DsjData::$dir_tournaments.'/'.$id_tournament;

        // load DSJ4 stats file 
        $file = file($path.'/standings/'.$id_competition.'.txt');

        $standings = DsjData::parseDsjStatStandingsHeader($file);
        $standings['results'] = DsjData::parseDsjStatStandings($file, $id_tournament, $id_competition, $compare);

        $data = array(
        	'tournament' => $tournament_meta,
        	'standings' => $standings,
            'latest_competition_id' => $id_competition,
        );

        //WARNING: this can be potentially significant performance bottleneck
        if($stats) $data['tournament']['stats'] = Tournament::getStats($id_tournament, $id_competition);

        return $data;

    }

    /**
     * use in Tournament or Ranking standings loop only
     * @param $row - row of standings data
     */
    public static function addTrend($row, $previousStanding) : array {

            foreach($previousStanding as $previous_results) {

                $found_in_previous_standings = false;

                if( $row['name'] === $previous_results['name']) {
                    
                    //tournament position change
                    $previous_position = (int)$previous_results['real_position'];
                    $current_position = (int)$row['real_position'];
                    $change = $previous_position - $current_position;

                    if($previous_position > $current_position) {
                        //previosly jumper had worse position
                        $trend = 'positive';
                    } elseif ($previous_position < $current_position) {
                        //previosly jumper had better position
                        $trend = "negative";
                    } elseif ($previous_position == $current_position) {
                        $trend = "neutral";
                    }

                    $row['previous_position'] = $previous_position;
                    $row['change'] = abs($change);
                    $row['trend'] = $trend;

                    $found_in_previous_standings = true;
                    break;
                }

            }

            //what if jumper wasn't present in previous standings?
            if(!$found_in_previous_standings) {
                $row['trend'] = 'positive';
                //TO DO: what about change?
            }
        return $row;

    }

    public static function getLeader($id_tournament, $id_competition) {

        if($id_competition == 1) return false;

        $standings = self::loadSingleStandings($id_tournament, $id_competition - 1, false, false);

        return $standings['standings']['results'][0]['name'];

    }

}


