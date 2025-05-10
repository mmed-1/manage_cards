<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\CarteSImBlr;
use App\Models\Equipement;
use App\Models\RechargeBlr;
use App\Models\Utilisateur;
use App\Models\UtilisateurPrincipale;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarteBlrController extends Controller
{
    public function test_connection() {
        if(!auth()->guard('admin')->check())
            return redirect(route('auth.login'));

        if(session()->has('guard'))
            Auth::shouldUse(session('guard'));
        return null;
    }

    public function index() {
        $equipements = Equipement::get();
        $comptes = UtilisateurPrincipale::get();
        return view('admin.ajoutBlr', [
            'equipements' => $equipements,
            'comptes' => $comptes
        ]);
    }

    public function create(Request $request) {
        
        if($this->test_connection()) return $this->test_connection();

        $validated = $request->validate([
            'ice' => 'required|regex:/^[0-9]+$/',
            'num_carte' => 'required|regex:/^[0-9]+$/',
            'num_port' => 'required|string',
            'operateur' => 'required|string',
            'equipement_id' => 'required',
            'liee_par' => 'required'
        ],[

            'ice.required' => 'Le champ ice est obligatoire.',
            'ice.regex' => 'ice doit contenir uniquement des chiffres.',

            'num_carte.required' => 'Le champ numéro de carte est obligatoire.',
            'num_carte.regex' => 'Le numéro de carte doit contenir uniquement des chiffres.',

            
            'num_port.required' => 'Le champ numéro de port est obligatoire.',

            'operateur.required' => "Le champ opérateur est obligatoire.",

            'equipement_id.required' => "Le champ équipement est obligatoire.",
            'compte.required' => "Il faut choisir un compte"
        ]);
        
        $user = Admin::find(auth()->guard("admin")->id());
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
        if($this->test_connection()) return $this->test_connection();

        $user = UtilisateurPrincipale::find(auth::guard('user_principale')->id()) ?? 
                                                Utilisateur::find(auth()->guard('user')->id());


        $request->validate([
            'search' => 'nullable|regex:/^[0-9]+$/'
        ],[
            'search.regex' => 'Entrer un numero s\'il vous plait'
        ]);

        $search = $request->input('search');
        $query = CarteSImBlr::query();


        if($search) {
            $query->where('carte_sim_blr.num_carte', $search);
        }

        $cartes = $query->get();

        return view('details.blr', ['cartes' => $cartes]);
    }

    public function found($id) {
        $carte = CarteSImBlr::find($id);
        $equipements = Equipement::get();
        $comptes = UtilisateurPrincipale::get();
        return view('pages.updateBlr', [
            'carte' => $carte,
            'equipements' => $equipements,
            'comptes' => $comptes
        ]);
    }

    public function update(Request $request, $id) {
        if($this->test_connection()) return $this->test_connection();
        $validated = $request->validate([
            'ice' => 'required|regex:/^[0-9]+$/',
            'num_carte' => 'required|regex:/^[0-9]+$/',
            'num_port' => 'required|string',
            'operateur' => 'required|string',
            'equipement_id' => 'required',
            'liee_par' => 'required'
        ],[
            'ice.required' => 'Le champ ice est obligatoire.',
            'ice.regex' => 'ice doit contenir uniquement des chiffres.',

            'num_carte.required' => 'Le champ numéro de carte est obligatoire.',
            'num_carte.regex' => 'Le numéro de carte doit contenir uniquement des chiffres.',

            
            'num_port.required' => 'Le champ numéro de port est obligatoire.',

            'operateur.required' => "Le champ opérateur est obligatoire.",

            'equipement_id.required' => "Le champ équipement est obligatoire.",
            'compte.required' => "Il faut choisir un compte"
        ]);

        $carte = CarteSImBlr::find($id);

        $carte->ice = $validated['ice'];
        $carte->num_port = $validated['num_port'];
        $carte->num_carte = $validated['num_carte'];
        $carte->operateur = $validated['operateur'];
        $carte->equipement_id = $validated['equipement_id'];
        $carte->liee_par = $validated['liee_par'];

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
        if($this->test_connection()) return $this->test_connection();
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

    public function display_admin(Request $request) {
        if(!auth()->guard('admin')->check()) return redirect(route('auth.login'));
        if(session()->has('guard')) Auth::shouldUse(session('guard'));

        $search = $request->get('search');

        $query = CarteSImBlr::query();

        if($search) {
            $query->where('carte_sim_blr.num_carte', $search)
                ->orWhere('carte_sim_blr.user_principale_id', function($subQ) use ($search) {
                    $subQ->select('user_principale_id')
                         ->from('utilisateurs_principale')
                         ->whereRaw("CONCAT(prenom, ' ', nom) LIKE ?", ['%' . $search . '%']);
                })
                ->orWhereIn('carte_sim_blr.user_id', function ($q) use ($search) {
                    $q->select('user_id')
                      ->from('utilisateurs')
                      ->where('user_principale_id', function ($subQ) use ($search) {
                        $subQ->select('user_principale_id')
                         ->from('utilisateurs_principale')
                         ->whereRaw("CONCAT(prenom, ' ', nom) LIKE ?", ['%' . $search . '%']);
                      });
                });
        }

        $cartes = $query->get();

        return view('admin.blr', ['cartes' => $cartes]);
    }

    public function details($id) {
        if($this->test_connection() && !auth()->guard('admin')->check()) return $this->test_connection();
        $carte = CarteSImBlr::find($id);
        $num_carte = $carte->num_carte;

        $query = RechargeBlr::query();

        $recharges = $query->where('recharge_carte_blr.carte_blr_id', $id)->get();
        $count = $recharges->count();

        return view('admin.blrDet', [
            'numero' => $num_carte,
            'count' => $count,
            'recharges' => $recharges,
            'x' => false
        ]);
    }
}
