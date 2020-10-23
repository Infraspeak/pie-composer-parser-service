<?php

namespace App\Repositories;
use Illuminate\Support\Facades\Http;

class PackagistRepository
{
   
    public static function getUrl($name){

        $response = Http::get('https://packagist.org/search.json', [
            'q' => $name
        ]);

        if($response['total'] === 0) {
            return null;            
        }

        return $response['results'][0]['repository'];
    }
}