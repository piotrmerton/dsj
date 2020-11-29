<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Jumper;
use App\Models\Tournament;

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

        //dd($data);

        return view('jumper', 
            ['data' => $data ]
        );
    }
}