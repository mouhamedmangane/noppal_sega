<?php

use App\Http\Controllers\BoisController;
use App\Http\Controllers\Contact\ContactController;
use App\Http\Controllers\Contact\PrixController;
use App\Http\Controllers\EpaisseurPlancheController;
use App\Http\Controllers\GenIdTronController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParamCompte\UserController as PCUserController;
use App\Http\Controllers\PlancheController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\TroncController;
use App\Http\Controllers\Vente\PaiementController;
use App\Http\Controllers\Vente\VenteController;
use App\Http\Controllers\Achat\AchatController;
use App\Http\Controllers\Achat\AchatTroncController;
use App\Http\Controllers\Achat\PaiementController as AchatPaiementController;
use App\Http\Controllers\Depense\DepenseController;
use App\Http\Controllers\ParamCompte\TypeDepenseController;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Http\Request;
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






Route::get('toggle_sidebar',function(Request $request){
    $validator=Validator::make($request->all(),[
        'active'=>'string|required'
    ]);
    if(!$validator->fails()){
        session(['toggle_sidebar'=>$request->active]);
    }
    return response()->json(['status'=>true]);

});


Route::middleware(['auth'])->group(function () {

    //Dashbord
    Route::get('home/{date?}',[HomeController::class,'index']);
    Route::get('home/encaissement/{date}',[HomeController::class,'encaissement_jour']);
    Route::get('home/depense/{date}',[HomeController::class,'depense_jour']);

    //coherence
    Route::get('coherence',[GenIdTronController::class,'index']);

    //bois
    Route::get('bois/data',[BoisController::class,'getData']);
    Route::get('bois/data/{filter}',[BoisController::class,'getData']);
    Route::get('bois/archiver/{id}',[BoisController::class,'archiver']);
    Route::get('bois/desarchiver/{id}',[BoisController::class,'desarchiver']);
    Route::get('bois/archiverMany',[BoisController::class,'archiverMany']);
    Route::get('bois/desarchiverMany',[BoisController::class,'desarchiverMany']);
    Route::delete('bois/destroyMany',[BoisController::class,'destroyMany']);
    Route::resources(['bois'=> BoisController::class]);

    //tronc
    Route::get('tronc/data',[TroncController::class,'getData']);
    Route::get('tronc/data/{filter}',[TroncController::class,'getData']);
    Route::get('tronc/archiver/{id}',[TroncController::class,'archiver']);
    Route::get('tronc/desarchiver/{id}',[TroncController::class,'desarchiver']);
    Route::get('tronc/archiverMany',[TroncController::class,'archiverMany']);
    Route::get('tronc/desarchiverMany',[TroncController::class,'desarchiverMany']);
    Route::delete('tronc/destroyMany',[TroncController::class,'destroyMany']);
    Route::resources(['tronc'=> TroncController::class]);

    //Planche
    Route::get('planche/data',[PlancheController::class,'getData']);
    Route::get('planche/data/{filter}',[PlancheController::class,'getData']);
    Route::get('planche/archiver/{id}',[PlancheController::class,'archiver']);
    Route::get('planche/desarchiver/{id}',[PlancheController::class,'desarchiver']);
    Route::get('planche/archiverMany',[PlancheController::class,'archiverMany']);
    Route::get('planche/desarchiverMany',[PlancheController::class,'desarchiverMany']);
    Route::delete('planche/destroyMany',[PlancheController::class,'destroyMany']);
    Route::resources(['planche'=> PlancheController::class]);

    //epaisseur planche
    Route::get('epaisseur_planche/data',[EpaisseurPlancheController::class,'getData']);
    Route::get('epaisseur_planche/data/{filter}',[EpaisseurPlancheController::class,'getData']);
    Route::get('epaisseur_planche/archiver/{id}',[EpaisseurPlancheController::class,'archiver']);
    Route::get('epaisseur_planche/desarchiver/{id}',[EpaisseurPlancheController::class,'desarchiver']);
    Route::get('epaisseur_planche/archiverMany',[EpaisseurPlancheController::class,'archiverMany']);
    Route::get('epaisseur_planche/desarchiverMany',[EpaisseurPlancheController::class,'desarchiverMany']);
    Route::delete('epaisseur_planche/destroyMany',[EpaisseurPlancheController::class,'destroyMany']);
    Route::post('epaisseur_planche/get',[EpaisseurPlancheController::class,'get']);
    Route::post('epaisseur_planche',[EpaisseurPlancheController::class,'store']);
    Route::resources(['epaisseur_planche'=> EpaisseurPlancheController::class]);

    // Contact
    Route::get('contact/data',[ContactController::class,'getData']);
    Route::get('contact/data/{filter}',[ContactController::class,'getData']);
    Route::get('contact/archiver/{id}',[ContactController::class,'archiver']);
    Route::get('contact/desarchiver/{id}',[ContactController::class,'desarchiver']);
    Route::get('contact/archiverMany',[ContactController::class,'archiverMany']);
    Route::get('contact/desarchiverMany',[ContactController::class,'desarchiverMany']);
    Route::get('contact/createwith/{vente_id}/{nom}/{tel?}',[ContactController::class,'createWith']);
    Route::delete('contact/destroyMany',[ContactController::class,'destroyMany']);
    Route::resources(['contact'=>ContactController::class]);

    //Vente
    Route::post('vente/save',  [VenteController::class,'store']);
    Route::get('vente/create',[VenteController::class,'create']);
    Route::get('vente/data',[VenteController::class,'returnVentes']);
    Route::get('vente/data/{filter}', [VenteController::class,'index']);
    Route::get('vente/print/{id}', [VenteController::class,'print']);
    Route::get('vente/printer/{id}', [VenteController::class,'printer']);
    Route::get('vente/print_facture/{id}', [VenteController::class,'print_facture']);
    Route::get('vente/view/{id}', [VenteController::class,'show']);
    Route::get('vente/data/{filter}', [VenteController::class,'returnVentes']);
    Route::get('vente/view/{id}', [VenteController::class,'show']);
    Route::get('vente/preter/{id}', [VenteController::class,'preter']);
    Route::delete('vente/many', [VenteController::class,'destroyMany']);
    Route::get('contact_prix/{id}', [PrixController::class,'getContactPrix']);
    Route::resources(['vente'=>VenteController::class]);

    //Paiement
    Route::get('vente/paiement/data/{id}', [PaiementController::class,'data']);
    Route::post('vente/paiement', [PaiementController::class,'store']);
    Route::delete('vente/paiement/delete', [PaiementController::class,'destroy']);

       //Changer profil
       Route::get('photo_form',[ProfilController::class,'photoForm']);
       Route::post('photo_save',[ProfilController::class,'savephoto']);
       Route::get('profil_form',[ProfilController::class,'profilForm']);
       Route::post('profil_save',[ProfilController::class,'profilSave']);

  // Route::get('venteProduit/categorie/{id}',[VenteController::class,'getProducts']);
    Route::post('achat/save',  [AchatController::class,'store']);

    Route::get('achat/depense/data/{type}/{id}',  [AchatPaiementController::class,'data']);
    Route::get('achat/depense/data/{type}/{id}',  [AchatPaiementController::class,'data']);
    Route::post('achat/paiement',  [AchatPaiementController::class,'store']);
    Route::delete('achat/paiement/delete', [AchatPaiementController::class,'destroy']);

    Route::get('achat/tronc/{id}',  [AchatTroncController::class,'index']);
    Route::get('achat/tronc_data/{id}/',  [AchatTroncController::class,'getData']);
    Route::post('achat/tronc_save/{idAchat}',  [AchatTroncController::class,'store']);

    Route::post('achat/ajaxPush',  [AchatController::class,'ajaxPush']);
    Route::get('achat/create',[AchatController::class,'create']);
    Route::get('achat/data',[AchatController::class,'getData']);
    Route::get('achat/data/{filter}', [AchatController::class,'getData']);
    Route::get('achat/datas/{id_fournisseur}/{filter?}', [AchatController::class,'getData']);
    Route::get('achat/print/{id}', [AchatController::class,'print']);
    Route::get('achat/printer/{id}', [AchatController::class,'printer']);
    Route::get('achat/print_facture/{id}', [AchatController::class,'print_facture']);
    Route::get('achat/view/{id}', [AchatController::class,'show']);
    // Route::get('achat/data/{filter}', [AchatController::class,'returnAchats']);
    Route::get('achat/view/{id}', [AchatController::class,'show']);
    Route::get('achat/preter/{id}', [AchatController::class,'preter']);
    Route::delete('achat/many', [AchatController::class,'destroyMany']);
    Route::get('contact_prix/{id}', [PrixController::class,'getContactPrix']);
    Route::resources(['achat'=>AchatController::class]);

    //tronc
    Route::get('depense/data',[DepenseController::class,'getData']);
    Route::get('depense/data/{filter}',[DepenseController::class,'getData']);
    Route::get('depense/archiver/{id}',[DepenseController::class,'archiver']);
    Route::get('depense/desarchiver/{id}',[DepenseController::class,'desarchiver']);
    Route::get('depense/archiverMany',[DepenseController::class,'archiverMany']);
    Route::get('depense/desarchiverMany',[DepenseController::class,'desarchiverMany']);
    Route::delete('depense/destroyMany',[DepenseController::class,'destroyMany']);
    Route::resources(['depense'=> DepenseController::class]);

});


Route::middleware([])->group(function () {
    //L'entrprrise
    Route::get('param-compte/entreprise',[App\Http\Controllers\ParamCompte\EntrepriseController::class,'index']);
    Route::post('param-compte/entreprise',[App\Http\Controllers\ParamCompte\EntrepriseController::class,'store']);

    // User
    Route::get('param-compte/users/data',[PCUserController::class,'getData']);
    Route::get('param-compte/users/data/{filter}',[PCUserController::class,'getData']);
    Route::get('param-compte/users/archiver/{id}',[PCUserController::class,'archiver']);
    Route::get('param-compte/users/desarchiver/{id}',[PCUserController::class,'desarchiver']);
    Route::get('param-compte/users/archiverMany',[PCUserController::class,'archiverMany']);
    Route::get('param-compte/users/desarchiverMany',[PCUserController::class,'desarchiverMany']);
    Route::resources(['param-compte/users'=>PCUserController::class]);

    // Role
    Route::get('param-compte/roles/data',[App\Http\Controllers\ParamCompte\RoleController::class,'getData']);
    Route::get('param-compte/roles/data/{filter}',[App\Http\Controllers\ParamCompte\RoleController::class,'getData']);
    Route::get('param-compte/roles/archiver/{id}',[App\Http\Controllers\ParamCompte\RoleController::class,'archiver']);
    Route::get('param-compte/roles/desarchiver/{id}',[App\Http\Controllers\ParamCompte\RoleController::class,'desarchiver']);
    Route::get('param-compte/roles/desarchiverMany',[App\Http\Controllers\ParamCompte\RoleController::class,'desarchiverMany']);
    Route::get('param-compte/roles/archiverMany',[App\Http\Controllers\ParamCompte\RoleController::class,'archiverMany']);
    Route::delete('param-compte/roles',[App\Http\Controllers\ParamCompte\RoleController::class,'destroyMany']);
    Route::resources(['param-compte/roles'=>App\Http\Controllers\ParamCompte\RoleController::class]);


    // User
    Route::get('param-compte/type_depense/data',[TypeDepenseController::class,'getData']);
    Route::get('param-compte/type_depense/data/{filter}',[TypeDepenseController::class,'getData']);
    Route::get('param-compte/type_depense/archiver/{id}',[TypeDepenseController::class,'archiver']);
    Route::get('param-compte/type_depense/desarchiver/{id}',[TypeDepenseController::class,'desarchiver']);
    Route::get('param-compte/type_depense/archiverMany',[TypeDepenseController::class,'archiverMany']);
    Route::get('param-compte/type_depense/desarchiverMany',[TypeDepenseController::class,'desarchiverMany']);
    Route::delete('param-compte/type_depense',[TypeDepenseController::class,'destroyMany']);
    Route::resources(['param-compte/type_depense'=>TypeDepenseController::class]);

});

Route::get('/', function () {
    return redirect('home');
});


require __DIR__.'/auth.php';
