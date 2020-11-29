<?php

namespace App\Models;

use App\Models\DsjData;
use Symfony\Component\Yaml\Yaml;

class Hill {


    public static function loadHills() : array {

        $path = DsjData::$dir_data;
        $data = Yaml::parseFile($path . '/'. 'hills.yml');
        return $data;

    }

    public static function getCountry(string $city) : string  {

        $hills = self::loadHills();


        foreach($hills as $key => $hill) {

            if($city === $key) return $hill['country'];

        }

        return false;

    } 

}


