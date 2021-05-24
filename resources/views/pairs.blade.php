<table>
    <tr>
        <th>Type</th>
        <th>Symbol</th>
        <th>Base Asset</th>
        <th>Quote Asset</th>
        <th>Price</th>
        <th>Vol</th>
    </tr>
    @php
    $curl = curl_init();
    @endphp

    @foreach($pairs as $pair)
    @php
    set_time_limit(0);
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.binance.cc/api/v3/aggTrades?symbol='.str_replace("_","",$pair['symbol']).'&limit=1',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    ));

    $response = curl_exec($curl);
    $response = json_decode($response, true);
    @endphp
    <tr>
        <td>{{$pair['type']}}</td>
        <td>{{$pair['symbol']}}</td>
        <td>{{$pair['baseAsset']}}</td>
        <td>{{$pair['quoteAsset']}}</td>
    </tr>
    @endforeach
    @php
    curl_close($curl);
    @endphp
</table>