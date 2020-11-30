<?php

namespace App\Models;

use App\Models\DsjData;
use App\Models\Competition;
use App\Models\Tournament;


class Ranking {

    const CUP_POINTS = array(
        1 => 100,
        2 => 80,
        3 => 60,
        4 => 50,
        5 => 45,
        6 => 40,
        7 => 36,
        8 => 32,
        9 => 29,
        10 => 26,
        11 => 24,
        12 => 22,
        13 => 20,
        14 => 18,
        15 => 16,
        16 => 15,
        17 => 14,
        18 => 13,
        19 => 12,
        20 => 11,
        21 => 10,
        22 => 9,
        23 => 8,
        24 => 7,
        25 => 6,
        26 => 5,
        27 => 4,
        28 => 3,
        29 => 2,
        30 => 1
    );

    /**
     * Rankings are dynamically generated standings based on array of competitions ids.
     * The main distinction: they dont have standard Standing data files from DSJ, but are calculated
     * "on the fly"
     */

    public static function loadRanking($id_tournament, $id_ranking, $stage = false) : array {

        $ranking_meta = self::getRankingMeta($id_tournament, $id_ranking); 

        $competitions_count = count($ranking_meta['competitions']);

        if($stage && (int)$stage <= $competitions_count) {
            $progress = $stage . '/' . $competitions_count;
        } else {
            $progress = $competitions_count . '/' . $competitions_count;
        }

        $ranking = array(
            'id' => $ranking_meta['id'],
            'name' => $ranking_meta['name'],
            'stage' => $progress,
            'number_of_competitions' => $competitions_count,
            'url' => route('ranking', array($id_tournament, $id_ranking) ),
            'standings' => self::getStandings($ranking_meta, $stage),

        );

        return $ranking;


    }
    
    private static function getStandings($ranking_meta, $stage = false, $trend = true) : array {

        $standings = array();
        $competitions_results = array();

        $points_rules = $ranking_meta['points'];

        //load results for ranking-related competitions
        foreach($ranking_meta['competitions'] as $id_competition) {
            $competitions_results[] = Competition::loadCompetition($ranking_meta['id_tournament'], $id_competition, false, false, false);
        }

        foreach($competitions_results as $iteration => $competition) {

            foreach($competition['results'] as $results) {

                $name = $results['name'];
                $real_position = $results['real_position'];

                if( !array_key_exists($name, $standings) ) {

                    if($points_rules == 'cup' && $real_position > 30) continue;

                    $standings[$name] = array(
                        'name' => $results['name'],
                        'country' => $results['country'],
                        'result' => self::calcResult($points_rules, $results, 0),
                        'final_round' => $real_position <= 30 ? 1 : 0,
                        'previous_position' => 0,
                        'trend' => null,
                    );

                } else {
                    $standings[$name]['result'] = self::calcResult($points_rules, $results, $standings[$name]['result']);
                    if( $results['real_position'] <= 30 ) $standings[$name]['final_round']++;
                }

            }

            $previous_stage = $iteration;

            if($stage && $iteration + 1 == $stage) break;

        }

        //sort by result and maintain key association
        uasort($standings, function($a, $b) {
            return $b['result'] <=> $a['result'];
        });

        //standings now are ready, let's now add some additional data like position, difference and trend

        //add positions to standings and calculate difference
        $real_position = 1;
        $iteration = 1;
        $previous_jumper_result = 0;
        $ex_aequo = 0;

        if($trend && $previous_stage > 0) $previous_stage_standings = self::getStandings($ranking_meta, $previous_stage, false);

        foreach($standings as $key => $jumper) {

            $current_jumper_result = $points_rules === 'cup' ? (int)$jumper['result'] : $jumper['result']; 

            if($iteration == 1) $top_score = $current_jumper_result;

            if( $previous_jumper_result == $current_jumper_result ) {
                $ex_aequo++;
                $real_position -= $ex_aequo;
            } else {
                $ex_aequo = 0;
            }

            $standings[$key]['real_position'] = $real_position;
            $standings[$key]['difference'] = $previous_jumper_result != 0 ? '-'.self::calcDiffernce($points_rules, $current_jumper_result, $top_score) : '';

            $iteration++;
            $real_position = $iteration;

            if(isset($previous_stage_standings)) $standings[$key] = Standings::addTrend($standings[$key], $previous_stage_standings);

            //save previous jumper results in order to save ex aequo position
            $previous_jumper_result = $current_jumper_result;      

        }

        return $standings;

    }

    private static function calcDiffernce($points_rules, $current_result, $top_score) {

        $difference = $top_score - $current_result;

        if($points_rules === 'cup') {
            return (int) $difference;
        } elseif ($points_rules === 'jump') {
            return number_format((float) $difference, 1, '.', ''); 
        }

    }

    private static function calcResult($points_rules, $results, $current_points) {

        $real_position = $results['real_position'];

        if($points_rules === 'cup') {
            $current_points += $real_position <= 30 ? (int)self::CUP_POINTS[$real_position] : 0;
        } elseif ($points_rules === 'jump') {
            $current_points += (float)$results['result'];
        }

        return $current_points;

    }

    private static function getRankingMeta($id_tournament, $id_ranking) {

        //rankings are defined in Tournament data yml file, so we need to load it first
        $tournament = Tournament::loadTournamentMeta($id_tournament);

        foreach($tournament['rankings'] as $ranking) {

            if($ranking['id'] == $id_ranking) {
                $ranking['id_tournament'] = $id_tournament;
                return $ranking;
            }

        }

        return false;

    }


}