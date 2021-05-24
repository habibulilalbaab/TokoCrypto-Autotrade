<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MagicController extends Controller
{
    public function index($symbol){
        set_time_limit(0);
        if (Cache::has('pairs')) {
            $pairs = Cache::get('pairs');
        }else {
            $pairs = json_decode(file_get_contents('https://www.tokocrypto.com/open/v1/common/symbols'), true);
            $pairs = $pairs['data']['list'];
            Cache::put('pairs', $pairs);
        }
        $i = 0;
        foreach ($pairs as $pair) {
            if ($pair['quoteAsset'] == $symbol) {
                $response = json_decode(file_get_contents('https://api.binance.cc/api/v3/aggTrades?symbol='.str_replace("_","",$pair['symbol']).'&limit=1'), true);

                $result = 100000/$response[0]['p'];
                $buys[$i] = array($pair['symbol'], $pair['baseAsset'], $response[0]['p'], $result);
                $i++;
            }
        }
        $j = 0;
        foreach ($pairs as $pair) {
            foreach ($buys as $buy) {
                if ($pair['quoteAsset'] == $buy[1]) {
                    $response = json_decode(file_get_contents('https://api.binance.cc/api/v3/aggTrades?symbol='.str_replace("_","",$pair['symbol']).'&limit=1'), true);

                    $result = $buy[3]/$response[0]['p'];
                    $step1[$j] = array($buy[1], $buy[3], $pair['symbol'], $pair['baseAsset'], $response[0]['p'], $result);
                }
            }
            $j++;
        }
        $k = 0;
        foreach ($pairs as $pair) {
            foreach ($step1 as $st1) {
                if ($pair['quoteAsset'] == $symbol) {
                    $response = json_decode(file_get_contents('https://api.binance.cc/api/v3/aggTrades?symbol='.str_replace("_","",$pair['symbol']).'&limit=1'), true);
                    usleep(500000);
                    $result = $st1[4]/$response[0]['p'];
                    $sells[$j] = array($st1[3], $st1[4], $pair['symbol'], $pair['baseAsset'], $response[0]['p'], $result);
                }
            }
            $k++;
        }
        return $sells;
    }
}
