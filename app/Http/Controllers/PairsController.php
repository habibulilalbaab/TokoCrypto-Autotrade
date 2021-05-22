<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PairsController extends Controller
{
    public function CURL_GET($url){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
    public function index(){
        if (Cache::has('pairs')) {
            $pairs = Cache::get('pairs');
        }else {    
            $pairs = $this->CURL_GET('https://www.tokocrypto.com/open/v1/common/symbols');
            $pairs = json_decode($pairs, true);
            $pairs = $pairs['data']['list'];
            Cache::put('pairs', $pairs);
        }
        return view('pairs', compact(
            'pairs'
        ));
    }
}
