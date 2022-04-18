<?php

use App\Http\Controllers\Api\ContactControllerApi;
use App\Http\Controllers\Api\TroncControllerApi;
use App\Http\Controllers\Api\VenteControllerApi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    return $user->createToken($request->device_name)->plainTextToken;
});
Route::post('produit/couper',[TroncControllerApi::class,'couper']);
Route::post('produit/couper_simple',[TroncControllerApi::class,'couper_simple']);
Route::get('produit/delete_couper/{produitId}',[TroncControllerApi::class,'deleteCouper']);
Route::get('produit/search/{search?}',[TroncControllerApi::class,'troncAcouper']);
Route::get('produit/journal/{date?}',[TroncControllerApi::class,'journal']);

Route::get('client/search/{search?}',[ContactControllerApi::class,'contactRecente']);

Route::get('vente/important/{contactId}',[VenteControllerApi::class,'important']);
Route::get('vente/importants/{search?}',[VenteControllerApi::class,'importants']);
Route::get('journee/{date?}',[VenteControllerApi::class,'journees']);

Route::get('bonjour',function(Request $reqsuest){
    return 'bonjour';
});



