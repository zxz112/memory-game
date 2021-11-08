<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/{any?}', function () {
    return view('welcome');
})->where('any', '^(?!api\/)[\/\w\.\,-]*')->where('any', '^(?!upload\/)[\/\w\.\,-]*');

Route::get('/', function () {
    return view('welcome');
});
Route::get('/upload/{filename}', function($filename){
    $path = resource_path() . '/img/' . $filename;

    if(!File::exists($path)) {
        return response()->json(['message' => 'Image not found.'], 404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

Route::resource('card', 'App\Http\Controllers\Api\CardController');
