<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Jumper;
use App\Models\Tournament;

class JumperController extends Controller
{


    public function display($name, $id_tournament)
    {


    	$jumper = new Jumper($name, $id_tournament);

        $data = array(
        	'name' => $jumper->name,
        	'stats' => $jumper->stats,
        );

        //dd($data);

        return view('jumper', 
            ['data' => $data ]
        );
    }
}