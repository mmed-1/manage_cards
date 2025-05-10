<?php

namespace App\Http\Controllers;

use App\Models\CarteSIm;
use App\Models\Client;
use App\Models\UtilisateurPrincipale;
use App\Models\Vehicule;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehiculeController extends Controller
{
    public function test_connection() {
        if(!auth()->guard('user_principale')->check())
            return redirect(route('auth.login'));
        
        if(session()->has('guard'))
            Auth::shouldUse(session('guard'));
        return null;
    }

    public function save(Request $request) {
        if($this->test_connection()) return $this->test_connection();

        $validated = $request->validate([
            'marque' => 'required|string',
            'matriculation' => 'required|string',
            'type' => 'required|string'
        ],[
            'marque.required' => 'La marque est requise.',
            'matriculation.required' => 'La matriculation est requise.',
            'type.required' => 'Le type est requis.',
        ]);

        $compte = UtilisateurPrincipale::find( auth()->guard('user_principale')->id());

        try {
            $vehicule = $compte->vehicule()->create($validated);
            if($vehicule)
                return redirect()->back()->with([
                    'create' => true,
                    'status' => 'success'
                ]);
        } catch(QueryException $e) {
            if($e->errorInfo[1] == 1062)
                return redirect()->back()->with([
                    'create'=> true,
                    'status' => 'unique'
                ]);
            
            return redirect()->back()->with( [
                'create'=> true,
                'status' => 'failed'
            ]);
        }
    }

    public function show(Request $request) {
        if($this->test_connection()) return $this->test_connection();
        $search = $request->input('search');

        $query = Vehicule::query();
        $user = UtilisateurPrincipale::find( auth()->guard('user_principale')->id());

        $query->where('vehicules.user_principale_id', $user->user_principale_id);

        if($search) 
            $vehicules = $query->where('matriculation', $search);

        $vehicules = $query->paginate(10);
        $vehicules->appends(['search' => $search]);

        return view('details.vehicules',['vehicules' => $vehicules]);
    }

    public function form($id) {
        $vehicule = Vehicule::find($id);
        return view('user_principale.updateV', ['vehicule'=> $vehicule]);
    }

    public function update(Request $request, $id) {
        if($this->test_connection()) return $this->test_connection();
        $validated = $request->validate([
            'marque' => 'required|string',
            'matriculation' => 'required|string',
            'type' => 'required|string'
        ],[
            'marque.required' => 'La marque est requise.',
            'matriculation.required' => 'La matriculation est requise.',
            'type.required' => 'Le type est requis.',
        ]);

        $vehicule = Vehicule::find($id);

        $vehicule->marque = $validated['marque'];
        $vehicule->matriculation = $validated['matriculation'];
        $vehicule->type = $validated['type'];
        try {
            if($vehicule->save())
                return redirect(route('vehicules.display'))->with([
                    'create' => true,
                    'status' => 'success'
                ]);
        } catch(QueryException $e) {
            if($e->errorInfo[1] == 1062)
                return redirect()->back()->with([
                    'create' => true,
                    'status' => 'unique'
                ]);

            return redirect()->back()->with([
                'create' => true,
                'status'=> 'failed'
            ]);
        }
    }

    public function destroy($id) {
        if($this->test_connection()) return $this->test_connection();
        $vehicule = Vehicule::find($id);
        try{
            if($vehicule->delete())
                return redirect(route('vehicules.display'))->with([
                    'delete' => true,
                    'status' => 'success'
                ]);
        } catch(QueryException $e) {
            return redirect(route('vehicules.display'))->with([
                'delete' => true,
                'status' => 'failed'
            ]);   
        }
    }

    public function details($id) {
        if($this->test_connection()) return $this->test_connection();
        $vehicule = Vehicule::find($id);

        $query = CarteSIm::query();
        $card = $query->where('carte_sim.vehicule_id', $vehicule->vehicule_id)
                    ->first();

        $query = Client::query();
        $client = $query->where('clients.client_id', $card->client_id)
                        ->first();

        return view('vehicules', [
            'card' => $card,
            'client', $client,
            'matricule' => $vehicule->matriculation
        ]);  
    }
}
