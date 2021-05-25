<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PairsController;
use App\Http\Controllers\MagicController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function (
    $data = array(
        "BIDR-BNB-ETH-BIDR",
        "BIDR-BTC-ETH-BIDR"
    )
) {
    return $data;
});
Route::get('/{symbol}', [PairsController::class, 'index']);
Route::get('/magic/{symbol}', [MagicController::class, 'index']);