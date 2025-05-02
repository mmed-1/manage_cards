<?php

namespace App\Http\Controllers;

use App\Models\Equipement;
use App\Models\Utilisateur;
use App\Models\UtilisateurPrincipale;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarteBlrController extends Controller
{
    public function index() {
        $equipements = Equipement::get();
        return view('pages.ajoutBlr', ['equipements' => $equipements]);    
    }

    public function create(Request $request) {
        if(!auth()->guard('user_principale')->check() && !auth()->guard('user')->check())
            return redirect(route('auth.login'));

        if(session()->has('guard'))
            Auth::shouldUse(session('guard'));

        if($request->input('reset') === 'annuler')
            return redirect(route('choice'));

        $validated = $request->validate([
            'num_carte' => 'required|regex:/^[0-9]+$/',
            'num_port' => 'required|string',
            'operateur' => 'required|string',
            'equipement_id' => 'required'
        ],[

        ]);

        $user = UtilisateurPrincipale::find(auth::guard('user_principale')->id()) ?? 
                                        Utilisateur::find(auth()->guard('user')->id());

        try {
            $carteBlr = $user->carte_blr()->create($validated);
            if($carteBlr)
                return redirect()->back()->with([
                    'create' => true,
                    'status' => 'success'
                ]);
        } catch(QueryException $e) {
            if($e->errorInfo[1] == 1062)
                return redirect()->back()->with([
                    'create' => true,
                    'status' => 'error'
                ]);
            return redirect()->back()->with([
                'create' => true,
                'status' => 'failed'
            ]);
        }
    }

    public function recharge(Request $request) {
        
    }
}
