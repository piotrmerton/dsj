<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Jumper;
use App\Models\Tournament;
use App\Breadcrumbs;

class JumperController extends Controller
{


    public function display($name, $id_tournament)
    {




    	$jumper = new Jumper($name, $id_tournament, true);

        $data = array(
        	'name' => $jumper->name,
            'country' => $jumper->country,
        	'stats' => $jumper->stats,
        );

        $breadcrumbs = new Breadcrumbs($data['stats']['tournament']['name'], route('tournament', $id_tournament));
        $breadcrumbs->add( $jumper->name, false);

        //dd($data);

        return view('jumper', 
            [
                'breadcrumbs' => $breadcrumbs->get(),
                'data' => $data 
            ]
        );
    }
}