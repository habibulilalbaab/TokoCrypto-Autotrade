<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PairsController extends Controller
{
    public function index(){
        if (Cache::has('pairs')) {
            $pairs = Cache::get('pairs');
        }else {    
            $pairs = json_decode(file_get_contents('https://www.tokocrypto.com/open/v1/common/symbols'), true);
            $pairs = $pairs['data']['list'];
            Cache::put('pairs', $pairs);
        }
        return view('pairs', compact(
            'pairs'
        ));
    }
}
