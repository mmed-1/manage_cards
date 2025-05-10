<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarteBlrController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompteController;
use App\Http\Controllers\EquipementController;
use App\Http\Controllers\SimController;
use App\Http\Controllers\StatisticController;
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


Route::get('/logout', [AuthController::class, 'logout'])->name('logout');



Route::prefix('/admin')->group(function () {

    Route::get('/admin/profile-info', [AdminController::class, 'info'])
        ->name('admin.info');

    Route::post('/admin/update/info', [AdminController::class,'update_admin'])
        ->name('admin.info2');


    Route::get('/gestion/ajout/blr', [CarteBlrController::class,'index'])
        ->name('admin-blr.add');

    Route::post('/gestion/blr/add', [CarteBlrController::class, 'create'])
        ->name('admin-blr.ajout');

    Route::get('/dashboard', [StatisticController::class, 'index'])
        ->name('admin.dashboard');

    Route::view('/home', 'admin.home')
        ->name('admin.home');


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

    Route::get('/gestion/carte/blr', [CarteBlrController::class, 'display_admin'])
        ->name('blr.admin');

    Route::match(['get', 'post'],'/gestion/carte/blr/search', [CarteBlrController::class, 'display_admin'])
        ->name('blr.search2');

    Route::get('/gestion/comptes/{id}/detaille', [CompteController::class, 'account_details'])
        ->name('account.det');

    Route::get('/equipement/{id}/detaills', [EquipementController::class, 'deteils'])
        ->name('eq.det');

    Route::get('/carte/blr/{id}/detaille', [CarteBlrController::class, 'details'])
        ->name('blr.det');

    Route::get('/carte/blr/{id}/modifier', [CarteBlrController::class, 'find'])
        ->name('blr.fd');

    Route::post('/carte/blr/{id}/modifier', [CarteBlrController::class, 'update_admin'])
        ->name('blr.upd');

    Route::get('/gestion/carte/blr/all', [CarteBlrController::class, 'show'])
        ->name('details.blr');

    Route::post('/gestion/carte/blr/recherche', [CarteBlrController::class, 'show'])
        ->name('blr.search');
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

    Route::match(['get', 'post'], '/choice/detaille-carte/search', [SimController::class,'displayCartes'])
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
    
    Route::get('/client/display-all', [ClientController::class,'show'])
        ->name('display.clients');

    Route::match(['get', 'post'], '/client/all/recherche', [ClientController::class,'show'])
        ->name('clients.search');

    Route::view('/client/choice', 'pages.choice2')->name('choice2');
    
    Route::get('/client/modification/{id}', [ClientController::class,'find'])
        ->name('client.modification');
    
    Route::post('/client/modification/u/{id}', [ClientController::class,'update'])
        ->name('client.update');
    
    Route::delete('/client/delete/{id}', [ClientController::class,'delete'])
        ->name('client.delete');

    Route::get('/client/detaille/{id}', [ClientController::class, 'detaille'])
        ->name('client.detaille');
    
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

    Route::get('/carte/blr/{id}', [CarteBlrController::class, 'found'])
        ->name('blr.found');

    Route::delete('/carte/blr/{id}/delete', [CarteBlrController::class, 'delete'])
        ->name('blr.delete');

    Route::post('/carte/blr/{id}/update', [CarteBlrController::class, 'update'])
        ->name('blr.update');

    Route::get('/carte/blr/{id}/detaille', [CarteBlrController::class, 'details'])
        ->name('gest.det');

    Route::get('/carte/sim/{id}/detaille', [SimController::class, 'details'])
        ->name('sim.det');

    Route::get('/utilisateur/{id}/detaille', [UserController::class, 'details'])
        ->name('user.det');
    
    Route::get('/vehicule/{id}/detaille', [VehiculeController::class, 'details'])
        ->name('ve.det');
});






Route::fallback(function () {
    return view('notFound'); // or return redirect('/'); or a custom message
});