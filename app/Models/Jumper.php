<?php

namespace App\Models;

use App\Models\Tournament;


class Jumper {

    public $name;
    public $country;
    public $stats;

    public function __construct($name, $id_tournament, $trends = false) {

        if( !isset($id_tournament)  ) die ('Error: no tournament provided');
        if( !isset($name)  ) die ('Error: no name provided');

        $this->stats = $this->getCompetitionsStats($id_tournament, $name, $trends);


    }

    private function getCompetitionsStats($id_tournament, $name, $trends = false) : array {

        $stats['tournament'] = Tournament::loadTournamentMeta($id_tournament);
        $stats['competitions'] = NULL;
        $stats['standings'] = array();
        $stats['top_three'] = 0;
        $stats['wins'] = 0;
        $stats['second'] = 0;
        $stats['third'] = 0;
        $stats['final_round'] = 0;

        //load full tournament (all competitions files, beware of performance; compare: https://www.sitepoint.com/performant-reading-big-files-php/)
        $tournament_competitions = Tournament::loadTournamentCompetitions($id_tournament, true);
        

        foreach( $tournament_competitions as $competition ) {

            //TO DO: continue if $competition['type'] == qualifications?

            $id_competition = $competition['id'];
            $city = $competition['venue']['city'];
            $hs = $competition['venue']['hs'];
            $qualified = false;
            
            foreach( $competition['results'] as $results ) {

                if($results['name'] === $name) {

                    $this->name = $results['name'];
                    $this->country = $results['country'];

                    if( $results['real_position'] <= 3) $stats['top_three']++;
                    if( $results['real_position'] == 2) $stats['second']++;
                    if( $results['real_position'] == 1) $stats['wins']++;
                    if( $results['real_position'] <= 30) $stats['final_round']++;

                    $qualified = true;

                    break;

                }

            }

            if( $qualified ) {
                $position = $results['real_position'];
                $qualified = false;
            } else {
                $position = 0;
            }

            /* load history of positions in Competitions and in Tournament after each Competition */
            if($trends) {
                $tournament_standings = self::getTournamentStats($id_tournament, $name);
                $stats['competitions'][$id_competition] = array(
                    'id' => $id_competition,
                    'name' => $city . ' ' . $hs,
                    'venue' => array(
                        'city' => $city,
                        'hs' => $hs,
                    ),
                    'url' => route('competition', array( 'id_tournament' => $id_tournament, 'id_competition' => $id_competition ) ),
                    'position' => $position,
                    'position_tournament' => $tournament_standings[$id_competition],
                );
                $stats['standings'] = $tournament_standings;              
            }



        }

        return $stats;


    }


    private function getTournamentStats($id_tournament, $name) : array {


        //load full tournament (all competitions files, beware of performance; compare: https://www.sitepoint.com/performant-reading-big-files-php/)
        $tournament_standings = Tournament::loadTournamentStandings($id_tournament, true);

        $positions = array();

        foreach( $tournament_standings as $standings ) {

            //TO DO: continue if $competition['type'] == qualifications?

            $id_competition = $standings['id_competition'];
            $found = false;
            
            foreach( $standings['standings'] as $results ) {

                if($results['name'] === $name) {

                    $found = true;

                    break;

                }

            }

            if( $found ) {
                $position = $results['real_position'];
            } else {
                $position = 0;
            }

            $data[$id_competition] = $position;

        }

        return $data;


    }    



}


