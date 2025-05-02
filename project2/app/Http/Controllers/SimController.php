<?php

namespace App\Http\Controllers;

use App\Models\CarteSIm;
use App\Models\Client;
use App\Models\Utilisateur;
use App\Models\UtilisateurPrincipale;
use App\Models\Vehicule;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SimController extends Controller
{
    // Controller
    public function createSim(Request $request) {
        if (!auth()->guard('user_principale')->check() && !auth()->guard('user')->check()) {
            return redirect(route('auth.login'))->withErrors(['auth' => 'Vous devez être connecté pour accéder à cette page.']);
        }
        
        if (session()->has('guard')) {
            Auth::shouldUse(session('guard'));
        }

        $validated = $request->validate([
            'ice' => 'required|string|regex:/^[0-9]+$/',
            'num_carte_sim' => 'required|string|regex:/^[0-9]+$/',
            'operateur' => 'required|string',
            'solde' => 'required|regex:/^\d+(\.\d+)?$/',
            'client_email' => 'required|email',
            'matricule' => 'required|string'

        ],[
            'ice.regex' => 'Le ICE doit contenir uniquement des chiffres.',
            'num.regex' => 'Le numéro de carte SIM doit contenir uniquement des chiffres.',
            'solde.regex' => 'Le solde doit être un nombre.',
            'client_email.required' => 'Veuillez entrer l\'adresse email du client.',
            'client_email.email' => 'Veuillez fournir une adresse email valide.',
            'matricule.required' => 'Le champ matricule est obligatoire.',
            'matricule.string' => 'Le matricule doit être une chaîne de caractères valide.'
        ]);


        $user = UtilisateurPrincipale::find(auth::guard('user_principale')->id()) ?? 
                                                Utilisateur::find(auth::guard('user')->id());

        $client = Client::where('email', $validated['client_email'])->first();
        if(!$client)
            return redirect()->back()->with([
                'create' => true,
                'status' => 'error'
            ]);
        
        $vehicule = Vehicule::where('matriculation', $validated['matricule'])->first();
        if(!$vehicule)
            return redirect()->back()->with([
                'create' => true,
                'status' => 'error2'
            ]);
        try{
            $carte = $user->carte_sim()->create([
                'ice' => $validated['ice'],
                'num_carte_sim' => $validated['num_carte_sim'],
                'operateur' => $validated['operateur'],
                'solde' => $validated['solde'],
                'client_id' => $client->client_id,
                'vehicule_id' => $vehicule->vehicule_id
            ]);
            if( $carte ){
                return redirect()->back()->with([
                    'create' => true,
                    'status' => 'success'
                ]);
            }
        } catch(QueryException $e){
            // dd($e->getMessage());
            if($e->errorInfo[1] == 1062)
                return redirect()->back()->with([
                    'create'=> true,
                    'error' => true
                ]);
            return redirect()->back()->with([
                'create' => true,
                'status' => 'failed'
            ]);
        }
    }
   

    public function displayCartes(Request $request) {
        $validated = $request->validate([
            'search' => 'regex:/^[0-9]+$/'
        ],[
            'search.regex' => 'Entrer un numero s\'il vous plait'
        ]);

        $search = $request->input('search');

        $query = CarteSIm::query();

        if($search)
            $query->where('ice', $search)
                  ->orWhere('num_carte_sim', $search);
        
        $cartes = $query->paginate(10);

        // Keep the search query in pagination links
        $cartes->appends(['search' => $search]);

        return view('details.details_cartes', ['cartes' => $cartes]);
    }

    public function carteForm($id) {
        $carteSIm = CarteSIm::find($id);
        return view('pages.update', ['carte' => $carteSIm]);
    }

    public function updateCarte(Request $request, $id) {
        $carteSIm = CarteSIm::find($id);
        
        if($carteSIm) {
            $validated = $request->validate([
                'ice' => 'required|string|regex:/^[0-9]+$/',
                'num' => 'required|string|regex:/^[0-9]+$/',
                'operateur' => 'required|string'
            ],[
                'ice.regex' => 'Le ICE doit contenir uniquement des chiffres',
                'num.regex' => 'Le numéro de carte SIM doit contenir uniquement des chiffres',
            ]);
            
            $carteSIm->ice = $validated['ice'];
            $carteSIm->num_carte_sim = $validated['num'];
            $carteSIm->operateur = $validated['operateur'];
    
            try {
                if($carteSIm->save()) {
                    return redirect(route('details'))->with([
                        'status'=>'success',
                        'submitted' => true
                    ]);
                } else {
                    return redirect(route('details'))->with([
                        'status'=>'failed',
                        'submitted' => true
                    ]);
                }
            }catch(QueryException $e) {
                if ($e->errorInfo[0] == 23000) {
                    return redirect(route('details'))
                        ->withErrors(['num' => 'Les informations sont deja existe dans le system.'])
                        ->withInput();
                }
                
                // For other database errors
                return redirect(route('details'))
                    ->withErrors(['general' => 'Une erreur technique est survenue. Veuillez réessayer plus tard.'])
                    ->withInput();
            }
        }
    }

    public function destroyCarte($id) {
        $carteSIm = CarteSIm::find($id);

        if($carteSIm->delete()) {
            return redirect(route('details'))->with([
                'status' => 'success',
                'delete' => true
            ]);
        } else {
            return redirect(route('details'))->with([
                'status'=> 'failed',
                'delete'=> true
            ]);
        }
    }
}
