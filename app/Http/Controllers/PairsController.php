<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PairsController extends Controller
{
    public function API_Request($symbol){
        $response = json_decode(file_get_contents('https://api.binance.cc/api/v3/aggTrades?symbol='.$symbol.'&limit=1'), true);
        return $response[0]['p'];
    }
    public function Calculate($val, $symbol, $operation){
        $result = $this->API_Request($symbol);
        if ($operation == "/") {
            return $val/$result;
        }elseif ($operation == "*") {
            return $val*$result;
        }
    }
    public function index($symbol){
        // BIDR
        if ($symbol == "BIDR-BNB-ETH-BIDR") {    
            return [
                "symbol" => $symbol,
                "A" => $init = 100000,
                "B" => $bnb = $this->Calculate($init, "BNBBIDR", "/"),
                "C" => $eth = $this->Calculate($bnb, "BNBETH", "*"),
                "D" => $final = $this->Calculate($eth, "ETHBIDR", "*"),
                "B_A" => $this->API_Request("BNBBIDR"),
                "B_B" => $this->API_Request("BNBETH"),
                "S_C" => $this->API_Request("ETHBIDR"),
                "profit"=> ($final-$init)/100
            ];
        }
        if ($symbol == "BIDR-BTC-ETH-BIDR") {
            return [
                "symbol" => $symbol,
                "A" => $init = 100000,
                "B" => $btc = $this->Calculate($init, "BTCBIDR", "/"),
                "C" => $eth = $this->Calculate($btc, "ETHBTC", "/"),
                "D" => $final = $this->Calculate($eth, "ETHBIDR", "*"),
                "B_A" => $this->API_Request("BTCBIDR"),
                "B_B" => $this->API_Request("ETHBTC"),
                "S_C" => $this->API_Request("ETHBIDR"),
                "profit" => ($final-$init)/100
            ];
        }
    }
}
