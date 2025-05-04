<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarteBlrController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompteController;
use App\Http\Controllers\EquipementController;
use App\Http\Controllers\SimController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehiculeController;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;



Route::get('/', function () : View{
    return view('auth.login');
})->name('auth.login');

Route::post('/login/verification', [AuthController::class, 'login'])
    ->name('login');

Route::get('/password/reset',function () {
    return view('auth.reset');
})->name('password.reset');






Route::prefix('/admin')->group(function () {
    Route::view('/home', 'admin.home')
        ->name('admin.home');

    Route::get('/creation/compte', function () {
        return view(''); //! don't forget that
    })->name('creation');

    Route::view('/gestion/equipement', 'admin.choice')
        ->name('admin.choice');

    Route::get('/ajout/equipement', function () {
        return view('admin.ajout_equi');
    })->name('ajout');

    Route::post('/ajout/equipement/add', [EquipementController::class,'create'])
        ->name('addEquipement');

    Route::get('/equipement/consultation', [EquipementController::class,'displayEquipements'])
        ->name('consultation');

    Route::get('/equipement/f/{id}', [EquipementController::class, 'equipement'])
        ->name('formEqui');

    Route::post('/equipement/update/{id}', [EquipementController::class,'update'])
        ->name('updateEquipement');

    Route::delete('/equipement/delete/{id}', [EquipementController::class,'destroy'])
        ->name('deleteEqui');
    
    Route::get('/gestion-comptes', function () {
        return view('admin.choice2');
    })->name('admin.choice2');

    Route::view('/gestion-comptes/ajout', 'admin.ajout_compte')
        ->name('admin.addAcc');
    
    Route::post('/gestion-comptes/ajout/compte', [CompteController::class, 'create'])
        ->name('compte.add');
    
    Route::get('/gestion-comptes/all-acc', [CompteController::class, 'show'])
        ->name('compte.details');
    
    Route::post('/gestion-compte/all-acc/search', [CompteController::class,'show'])
        ->name('search.acc');

    Route::post('/gestion-comptes/update/compte/{id}', [CompteController::class, 'edit'])
        ->name('compte.edit');

    Route::get('/gestion-comptes/update/compte/{id}', [CompteController::class, 'showCompte'])
        ->name('show.update');

    Route::delete('/gestion-comptes/delete/compte/{id}', [CompteController::class, 'delete'])
        ->name('compte.delete');
});




Route::prefix('/gestion')->group(function () {

    Route::get('/home', function () {
        return view('pages.index');
    })->name('home');

    Route::get('/choice', function () {
        return view('pages.choice');
    })->name('choice');

    Route::get('/choice/add-sim', function () {
        return view('PAGES.add');
    })->name('add_sim');

    Route::post('/choice/detaille-carte/search', [SimController::class,'displayCartes'])
        ->name('details.search');

    Route::get('/choice/detaille-carte', [SimController::class, 'displayCartes'])
        ->name('details');

    Route::post('/add-card', [SimController::class, 'createSim']);

    Route::get('/update/{id}', [SimController::class,'carteForm'])->name('edit');

    Route::post('/edit/{id}', [SimController::class,'updateCarte'])->name('update');

    Route::delete('/delete/{id}', [SimController::class,'destroyCarte'])->name('delete');

    Route::view('/client/creation', 'pages.addAcc')
        ->name('creation.client');

    Route::post('/client/creation/ajout', [ClientController::class, 'create'])
        ->name('ajout.client');
    
    Route::get('/client/detaille', [ClientController::class,'display_all'])
        ->name('display.clients');

    Route::view('/client/choice', 'pages.choice2')->name('choice2');
    
    Route::get('/client/modification/{id}', [ClientController::class,'find'])
        ->name('client.modification');
    
    Route::post('/client/modification/u/{id}', [ClientController::class,'update'])
        ->name('client.update');
    
    Route::delete('/client/delete/{id}', [ClientController::class,'delete'])
        ->name('client.delete');

    Route::get('/client/detaille/{id}', [ClientController::class, 'detaille'])
        ->name('client.detaille');

    Route::get('/carte/blr', [CarteBlrController::class, 'index'])
        ->name('blr.ajout');

    Route::post('/carte/blr/ajout', [CarteBlrController::class,'create'])
        ->name('blr.add');
    
    Route::view('/utilisateurs', 'user_principale.choice')
        ->name('compte.choice');

    Route::view('/utilisateurs/ajout', 'user_principale.addUser')
        ->name('compte.userAjout');

    Route::post('/utilisateurs/ajout/user', [UserController::class,'save'])
        ->name('compte.addAcc');

    Route::get('/utilisateurs/display-all', [UserController::class,'show'])
        ->name('users.details');

    Route::post('/utilisateurs/display', [UserController::class,'show'])    
        ->name('users.search');

    Route::delete('/utilisateurs/{id}/delete', [UserController::class,'delete'])
        ->name('user.delete');

    Route::get('/utilisateurs/update/{id}/user', [UserController::class, 'display'])
        ->name('update.user1');

    Route::post('/utilisateurs/update/{id}/user', [UserController::class, 'update'])
        ->name('update.user0');

    Route::view('/vehicules', 'user_principale.choiceV')
        ->name('choice.vehicule');

    Route::view('/vehicules/ajout', 'user_principale.ajoutV')
        ->name('vehicule.form');

    Route::post('/vehicules/ajout/vehicule', [VehiculeController::class, 'save'])
        ->name('vehicule.add');

    Route::get('/vehicules/display-all', [VehiculeController::class, 'show'])
        ->name('vehicules.display');

    Route::post('/vehicules/display-all/search', [VehiculeController::class, 'show'])
        ->name('vehicules.search');

    Route::get('/vehicules/update/{id}/vehicule', [VehiculeController::class, 'form'])
        ->name('vehicule.form2');

    Route::post('/vehicules/update/{id}/vehicule', [VehiculeController::class, 'update'])
        ->name('vehicule.update');

    Route::delete('/vehicules/delete/{id}/vehicule', [VehiculeController::class, 'destroy'])
        ->name('vehicule.delete');

    Route::get('/carte/blr/all', [CarteBlrController::class, 'show'])
        ->name('details.blr');
});