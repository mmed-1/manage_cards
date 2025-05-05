<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Utilisateur;
use App\Models\UtilisateurPrincipale;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{

    public function test_connection() {
        if (!auth()->guard('user_principale')->check() && !auth()->guard('user')->check()) 
            return redirect(route('auth.login'))->withErrors(['auth' => 'Authentication required']);

        if (session()->has('guard')) {
            Auth::shouldUse(session('guard'));
        }
    }

    public function create(Request $request) {
        $this->test_connection();
        $validated = $request->validate([
            "nom"=> "string|required",
            "prenom" => "string|required",
            "email"=> "string|required|email"
        ],[
            'nom.required' => 'Le nom est un champ obligatoire',
            'prenom.required' => 'Le prenom est un champ obligatoire',
            'email.rquired'=> 'L\'email est un champ obligatoire',
            'email.email' => 'il faut entrer un email'
        ]);
        try {
            $user = UtilisateurPrincipale::find(auth::guard('user_principale')->id()) ?? 
                                                    Utilisateur::find(auth::guard('user')->id());
            if($user) {
                $client = $user->clients()->create($validated);
                if($client) {
                    return redirect()->back()->with([
                        'creer' => true,
                        'status' => 'success'
                    ]);
                } else {
                    return redirect()->back()->with([
                        'creer' => true,
                        'status' => 'failed'
                    ]);
                }
            }
        } catch (QueryException $e) {
            if($e->errorInfo[1] === 1062) {
                return redirect()->back()->with([
                    'creer' => true,
                    'error' => true
                ]);
            }
            return redirect()->back()->with([
                'creer' => true,
                'error' => false
            ]);
        }
    }

    public function show(Request $request): View {
        $this->test_connection();

        $user = UtilisateurPrincipale::find(auth::guard('user_principale')->id()) ?? 
                                                    Utilisateur::find(auth::guard('user')->id());
        

        $request->validate([
            'search' => 'string'
        ]);

        $search = $request->input('search');

        $query = Client::query();

        $query->where(function ($q) use ($user) {
            if($user instanceof UtilisateurPrincipale) {
                $q->where('clients.user_principale_id', $user->user_principale_id)
                    ->orWhereIn('clients.user_id', function ($subQ) use ($user) {
                        $subQ->select('user_id')
                            ->from('utilisateurs')
                            ->where('user_principale_id', $user->user_principale_id);
                    });
            } else {
                $q->where('clients.user_id', $user->user_id)
                    ->orWhere('clients.user_principale_id', $user->user_principale_id)
                    ->orWhereIn('clients.user_id', function ($subQ) use ($user) {
                        $subQ->select('user_id')
                            ->from('utilisateurs')
                            ->where('user_principale_id', $user->user_principale_id);
                    });
            }
        });

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where(DB::raw("CONCAT(prenom, ' ', nom)"), 'LIKE', "%{$search}%")
                  ->orWhere('email', $search);
            });
        }

        $clients = $query->paginate(10);
        
        return view('details.clients', ['clients' => $clients]);
    }

    public function find($id): View {
        $client = Client::find($id);
        return view('pages.updateC', ['client' => $client]);
    }

    public function update(Request $request, $id) {
        $this->test_connection();
        if($request->input('reset') === 'Annuler')
            return redirect(route('display.clients'));

        $validated = $request->validate([
            'nom' => 'string|required',
            'prenom' => 'string|required',
            'email' => 'string|required'
        ],[
            'nom.required'=> 'Le nom est un champ obligatoire',
            'prenom.required'=> 'Le prenom est un champ obligatoire',
            'email.required'=> 'L\'email est un champ obligatoire',
        ]);

        $client = Client::find($id);

        $client->nom = $validated['nom'];
        $client->prenom = $validated['prenom'];
        $client->email = $validated['email'];

        try {
            if($client->save()) {
                return redirect(route('display.clients'))->with([
                    'status'=> 'success',
                    'up' => true
                ]);
            }
        } catch(QueryException $e) {
            if($e->errorInfo[1] == 1062) {
                return redirect()->back()->with([
                    'error'=> 'email',
                    'update' => true
                ]);
            }
            return redirect()->back()->with([
                'error'=> 'something',
                'update' => true
            ]);
        }
    }

    public function delete($id) {
        $this->test_connection();
        $client = Client::find($id);
        if($client->delete()) {
            return redirect()->back()->with([
                'status'=> 'success',
                'delete' => true
            ]);
        }
        return redirect()->back()->with([
            'status'=> 'failed',
            'delete' => true
        ]);
    }

    public function detaille($id) {
        $this->test_connection();
        $client = Client::find($id);
        
        $cartes = $client->carte_sim;

        return view('details.details_client', [
            'client' => $client,
            'cartes' => $cartes
        ]);
    }
}
