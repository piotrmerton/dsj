<?php

namespace App\Models;

define('PATH', base_path() ); //TO DO: https://stackoverflow.com/questions/42155536/what-is-the-best-practice-for-adding-constants-in-laravel-long-list


class DsjData {
    

	public static $dir_tournaments = PATH . '\data\tournaments'; 


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
            'venue' => array(
                'city' => trim($hillname),
                'hs' => $hill[$hs_position]
            ),
            'type' => $type,
            'date' => strtotime($date[2]),

        );

        return $header;

    }


    public static function parseDsjStatResults($file, $type) : array {

        $real_position = 1;
        $iteration = 1;
        $previous_jumper_result = 0;
        $ex_aequo = 0;

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
            );

            $iteration++;
            $real_position = $iteration;

            //save previous jumper results in order to save ex aequo position
            $previous_jumper_result = $result;

        }

        return $results;

    }

    public static function parseDsjStatStandings($file) : array {

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
                'real_position' => $real_position,
                'position' => $position,
                'name' => $name,
                'country' => $country,
                'points' => $points,
                'difference' => $previous_jumper_result != 0 ? '-'.($top_score - $points) : '',
            );

            $iteration++;
            $real_position = $iteration;

            //save previous jumper results in order to save ex aequo position
            $previous_jumper_result = $points;

        }

        return $standings;

    }




}
