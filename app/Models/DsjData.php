<?php

namespace App\Models;

use App\Models\Jumper;
use App\Models\Hill;

define('PATH', base_path() ); //TO DO: https://stackoverflow.com/questions/42155536/what-is-the-best-practice-for-adding-constants-in-laravel-long-list


class DsjData {
    
    public static $dir_data = PATH . '\data';
	public static $dir_tournaments = PATH . '\data\tournaments'; 

    /**
     * parse Header of single Competition Standings file
     */
    public static function parseDsjStatHeader($file) : array {

        $date = preg_split('/\s+/', $file[0]);
        $hill = preg_split('/\s+/', $file[1]);

        /** 
         * Line with the hill is a little tricky to split because it can either be:
         * "Kuusamo HS142 Wyniki konkursu" or "Bad Mitterndorf HS200 Wyniki konkursu"
         */

        $hs_position = (int) NULL;
        $hillname = (string) NULL;
        $type = (string) NULL;

        // Let's find word with "HS" to determine Hill Name length
        foreach($hill as $key => $word) {
            if( strpos($word, 'HS') !== false ) {
                $hs_position = $key;
                break;
            }                
        }

        // Now, since we know position of the word with HS, let's build hillname string
        for($i = 0; $i < $hs_position; $i++ ) {
            $hillname .= $hill[$i].' ';
        }
        $hillname = trim($hillname);

        // "Wyniki konkursu" or "Wyniki kwalifikacji"
        switch ( $hill[$hs_position + 2] ) {
            case 'konkursu':
                $type = 'final';
            break;
            case 'kwalifikacji':
                $type = 'qualifications';
            break;
        }

        $header = array(
            'name' => $hillname . ' ' . $hill[$hs_position],
            'venue' => array(
                'city' => $hillname,
                'hs' => $hill[$hs_position]
            ),
            'country' => Hill::getCountry($hillname),
            'type' => $type,
            'date' => strtotime($date[2]),

        );

        return $header;

    }

    /**
     * parse Results of single Competition Standings file
     */
    public static function parseDsjStatResults(array $file, string $type = 'final') : array {

        $real_position = 1;
        $iteration = 1;
        $previous_jumper_result = 0;
        $ex_aequo = 0;
        $qualified = 0;

        foreach($file as $key => $line) {

            if($key <= 3) continue;

            $line = preg_split('/\s\s+/', $line); //https://stackoverflow.com/questions/7961599/using-preg-split-with-multiple-spaces/49606158

            if( $type == 'final' ) {

                $position = (int)$line[0];
                $bib = (int)$line[1];
                $name = $line[2];
                $country = $line[3];
                $round1 = $line[4];
                $round2 = $iteration <= 30 ? $line[5] : 0;
                $result = $iteration <= 30 ? $line[6] : $line[5];

            } elseif ( $type == 'qualifications' ) {

                $position = (int)$line[0];
                $bib = (int)$line[1];
                $name = $line[2];
                $country = $line[3];
                $round1 = $line[4];
                $round2 = 0;
                $result = $line[5];
                $qualified = $line[6];
            }

            if( $previous_jumper_result == $result ) {
                $ex_aequo++;
                $real_position -= $ex_aequo;
            } else {
                $ex_aequo = 0;
            }

            $results[] = array(
                'real_position' => $real_position,
                'position' => $position,
                'bib' => $bib,
                'name' => $name,
                'country' => $country,
                'round1' => $round1,
                'round2' => $round2,
                'result' => $result,
                'previous_jumper_result' => $previous_jumper_result,
                'qualified' => $qualified ? $qualified : null,
            );

            $iteration++;
            $real_position = $iteration;

            //save previous jumper results in order to save ex aequo position
            $previous_jumper_result = $result;

        }

        return $results;

    }


    /**
     * parse Header of Tournament Standings file
     */
    public static function parseDsjStatStandingsHeader(array $file) : array {

        $date = preg_split('/\s+/', $file[0]);
        $stage = preg_split('/\s+/', $file[1]);

        $header = array(
            'stage' => $stage[2],
            'date' => strtotime($date[2]),

        );

        return $header;

    }

    /**
     * parse Results of Tournament Standings file
     */
    public static function parseDsjStatStandings(array $file, string $id_tournament = NULL, int $id_competition = NULL, bool $compare = true) : array {

        $real_position = 1;
        $iteration = 1;
        $previous_jumper_result = 0;
        $top_score = 0;
        $ex_aequo = 0;

        foreach($file as $key => $line) {

            if($key <= 3) continue;

            $line = preg_split('/\s\s+/', $line); //https://stackoverflow.com/questions/7961599/using-preg-split-with-multiple-spaces/49606158

                $position = (int)$line[0];
                $name = $line[1];
                $country = $line[2];
                $points = (int)$line[6];

            if($points == 0) {
                break;
            }

            if( $previous_jumper_result == $points ) {
                $ex_aequo++;
                $real_position -= $ex_aequo;
            } else {
                $ex_aequo = 0;
            }

            if($iteration == 1) $top_score = $points;

            $standings[] = array(
                'name' => $name,
                'country' => $country,                
                'real_position' => $real_position,
                'position' => $position,
                'points' => $points,
                'difference' => $previous_jumper_result != 0 ? '-'.($top_score - $points) : '',
                'previous_position' => null,
                'trend' => null,
            );

            $iteration++;
            $real_position = $iteration;

            //save previous jumper results in order to save ex aequo position
            $previous_jumper_result = $points;

            //trend in Tournament
            if(isset($id_tournament) && isset($id_competition) && $id_competition > 1 && $compare == true) {

                $previous_standings = Standings::loadSingleStandings($id_tournament, (int)$id_competition - 1, false);

                foreach($standings as $key => $current_results) {

                    foreach($previous_standings['standings']['results'] as $previous_results) {

                        if( $current_results['name'] === $previous_results['name']) {
                            

                            //tournament position change
                            $previous_position = (int)$previous_results['real_position'];
                            $current_position = (int)$current_results['real_position'];
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

                            $standings[$key]['previous_position'] = $previous_position;
                            $standings[$key]['change'] = abs($change);
                            $standings[$key]['trend'] = $trend;

                            break;
                        }

                    }

                }
            }

        }

        return $standings;

    }


}
