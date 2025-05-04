<?php

namespace App\Http\Controllers;

use App\Models\CarteSImBlr;
use App\Models\Equipement;
use App\Models\Utilisateur;
use App\Models\UtilisateurPrincipale;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarteBlrController extends Controller
{
    public function test_connection() {
        if(!auth()->guard('user_principale')->check() && !auth()->guard('user')->check())
            return redirect(route('auth.login'));

        if(session()->has('guard'))
            Auth::shouldUse(session('guard'));
    }

    public function index() {
        $equipements = Equipement::get();
        return view('pages.ajoutBlr', ['equipements' => $equipements]);    
    }

    public function create(Request $request) {
        
        $this->test_connection();

        if($request->input('reset') === 'annuler')
            return redirect(route('choice'));

        $validated = $request->validate([
            'num_carte' => 'required|regex:/^[0-9]+$/',
            'num_port' => 'required|string',
            'operateur' => 'required|string',
            'equipement_id' => 'required'
        ],[
            'num_carte.required' => 'Le champ numéro de carte est obligatoire.',
            'num_carte.regex' => 'Le numéro de carte doit contenir uniquement des chiffres.',
            
            'num_port.required' => 'Le champ numéro de port est obligatoire.',

            'operateur.required' => "Le champ opérateur est obligatoire.",

            'equipement_id.required' => "Le champ équipement est obligatoire.",
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

    public function show(Request $request) {
        $this->test_connection();

        $user = UtilisateurPrincipale::find(auth::guard('user_principale')->id()) ?? 
                                                Utilisateur::find(auth()->guard('user')->id());


        $validated = $request->validate([
            'search' => 'regex:/^[0-9]+$/'
        ],[
            'search.regex' => 'Entrer un numero s\'il vous plait'
        ]);

        $search = $request->input('search');

        $query = CarteSImBlr::query();

        $cartes = $query->where(function ($subQ) use ($user) {
            if($user instanceof UtilisateurPrincipale) {
                $subQ->where('carte_sim_blr.user_principale_id', $user->user_principale_id)
                     ->orWhereIn('carte_sim_blr.user_id', function ($q) use ($user) {
                        $q->select('user_id')
                          ->from('utilisateurs')
                          ->where('user_principale_id', $user->user_principlae_id);
                    });
            } else {
                $subQ->where('carte_sim_blr.user_principale_id', $user->user_principale_id)
                    ->orWhere('carte_sim_blr.user_id', $user->user_id)
                    ->orWhereIn('carte_sim_blr.user_id', function ($q) use ($user) {
                        $q->select('user_id')
                          ->from('utilisateurs')
                          ->where('user_principale_id', $user->user_principale_id);
                    });
            }
        });

        if($search) {
            $cartes = $query->where('carte_sim_blr.num_carte', $search);
        }

        $cartes = $query->paginate(10);

        return view('details.blr', ['cartes' => $cartes]);
    }

    public function found($id) {
        $carte = CarteSImBlr::find($id);
        return view('pages.updateBlr', ['carte' => $carte]);
    }

    public function update(Request $request, $id) {
        $this->test_connection();
        $validated = $request->validate([
            'num_carte' => 'required|regex:/^[0-9]+$/',
            'operateur' => 'required|string',
        ],[
            'num_carte.required' => 'Le champ numéro de carte est obligatoire.',
            'num_carte.regex' => 'Le numéro de carte doit contenir uniquement des chiffres.',
            
            'num_port.required' => 'Le champ numéro de port est obligatoire.',

            'operateur.required' => "Le champ opérateur est obligatoire.",
        ]);

        $carte = CarteSImBlr::find($id);

        $carte->num_carte = $validated['num_carte'];
        $carte->operateur = $validated['operateur'];

        try {
            if($carte->save()) {
                return redirect(route('details.blr'))->with([
                    'update' => true,
                    'status' => 'success',
                ]);
            }
        } catch(QueryException $e) {
            if($e->errorInfo[1] == 1062) 
                return redirect()->back()->with([
                    'update'=> true,
                    'status' => 'unique'
                ]);
            return redirect()->back()->with([
                'update'=> true,
                'status'=> 'failed'
            ]);
        }
    }

    public function delete($id) {
        $this->test_connection();
        $carte = CarteSImBlr::find($id);

        try {
            if($carte->delete())
                return redirect(route('details.blr'))->with([
                    'delete' => true,
                    'status' => 'success'
                ]);
        } catch(QueryException $e) {
            return redirect(route('details.blr'))->with([
                'delete' => true,
                'status' => 'failed'
            ]);
        }
    }
}
