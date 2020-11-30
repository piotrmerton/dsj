<?php

namespace App\Models;

use App\Models\DsjData;
use App\Models\Competition;
use App\Models\Tournament;


class Ranking {


    /**
     * Rankings are dynamically generated standings based on array of competitions ids.
     * The main distinction: they dont have standard Standing data files from DSJ, but are calculated
     * "on the fly"
     */

    public static function loadRanking($id_tournament, $id_ranking, $stage = false) : array {

    
        $ranking_meta = self::getRankingMeta($id_tournament, $id_ranking); 

        $competitions_results = array();

        //load results for ranking-related competitions
        foreach($ranking_meta['competitions'] as $id_competition) {
            $competitions_results[] = Competition::loadCompetition($id_tournament, $id_competition, false, false, false);
        }

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
            'standings' => self::getStandings($competitions_results, $ranking_meta['points'], $stage),

        );

        return $ranking;


    }


    private static function getStandings($competitions_results, $points, $stage = false) : array {

        $standings = array();

        foreach($competitions_results as $iteration => $competition) {

            foreach($competition['results'] as $results) {

                $name = $results['name'];

                if( !array_key_exists($name, $standings) ) {

                    $standings[$name] = array(

                        'name' => $results['name'],
                        'country' => $results['country'],
                        'jump_points' => (float) $results['result'],
                        'final_round' => $results['real_position'] <= 30 ? 1 : 0,

                    );

                } else {
                    
                    $standings[$name]['jump_points'] += (float) $results['result'];
                    if( $results['real_position'] <= 30 ) $standings[$name]['final_round']++;

                }

            }

            if($stage && $iteration + 1 == $stage) break;

        }

        uasort($standings, function($a, $b) {
            return $b['jump_points'] <=> $a['jump_points'];
        });        

        return $standings;

    }

    private static function getRankingMeta($id_tournament, $id_ranking) {

        //rankings are defined in Tournament data yml file, so we need to load it first
        $tournament = Tournament::loadTournamentMeta($id_tournament);

        foreach($tournament['rankings'] as $ranking) {

            if($ranking['id'] == $id_ranking) {
                return $ranking;
            }

        }

        return false;

    }


}