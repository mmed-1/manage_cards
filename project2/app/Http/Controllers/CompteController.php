<?php

namespace App\Http\Controllers;

use App\Mail\CreationMail;
use App\Mail\UpdateAccMail;
use App\Models\Admin;
use App\Models\CarteSIm;
use App\Models\CarteSImBlr;
use App\Models\Utilisateur;
use App\Models\UtilisateurPrincipale;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class CompteController extends Controller
{
    public function emailExisteDeja($email): bool
    {
        return Utilisateur::where('email', $email)->exists() ||
                            Admin::where('email', $email)->exists();
    }

    public function test_connection() {
        if(!auth()->guard('admin')->check())
            return redirect(route('auth.login'));
        
        if(session()->has('guard'))
            Auth::shouldUse(session('guard'));
        return null;
    }

    public function create(Request $request) {
        
        if($this->test_connection()) return $this->test_connection();

        $admin = Admin::find(auth()->guard('admin')->id());
        $validated = $request->validate([
            'nom' => 'string|required',
            'prenom' => 'string|required',
            'email' => 'required|email',
            'password'=> 'required|min:8|confirmed',
        ],[
            'nom.required' => 'Le nom est requis.',
            
            'prenom.required' => 'Le prénom est requis.',
            
            'email.required' => 'L\'adresse e-mail est requise.',
            'email.email' => 'L\'adresse e-mail doit être valide.',

            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        if($this->emailExisteDeja($validated['email']))
            return redirect()->back()->with([
                'create' => true,
                'status' => 'exist'
            ]);
        
        try {
            $compte = $admin->utilisateur_principales()->create($validated);
            if($compte) {
                try{
                    Mail::to($validated['email'])->send(new CreationMail([
                        'nom' => $validated['nom'],
                        'prenom' => $validated['prenom'],
                        'password' => $validated['password'],
                    ]));

                    return redirect()->back()->with([
                        'create' => true,
                        'status'=> 'success'
                    ]);
                }catch(\Exception $e){
                    return redirect()->back()->with([
                        'create' => true,
                        'status'=> 'mailFailed'
                    ]);
                }
            }
        } catch(QueryException $e) {
            if($e->errorInfo[1] === 1062)
                return redirect()->back()->with([
                    'create' => true,
                    'status' => 'unique'
                ]);
            return redirect()->back()->with([
                'create' => true,
                'status' => 'failed'
            ]);
        }
    }

    public function show(Request $request) {
        if($this->test_connection()) return $this->test_connection();
        $search = $request->input('search');

        $query = UtilisateurPrincipale::query();

        if($search) {
            $query->where(function ($q) use ($search) {
                $q->whereRaw("CONCAT(prenom, ' ', nom) LIKE ?", ["%$search%"])
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        $comptes = $query->paginate(10);

        $comptes->appends(['search' => $search]);
        return view('details.comptes', ['comptes' => $comptes]);
    }

    public function showCompte($id) {
        $compte = UtilisateurPrincipale::find($id);
        return view('admin.updateAcc', ['compte'=> $compte]);
    }

    public function edit(Request $request, $id) {
        if($this->test_connection()) return $this->test_connection();

        $validated = $request->validate([
            'nom' => 'string|required',
            'prenom' => 'string|required',
            'email' => 'required|email',
            'password'=> 'nullable|min:8|confirmed',
        ],[
            'nom.required' => 'Le nom est requis.',
            
            'prenom.required' => 'Le prénom est requis.',
            
            'email.required' => 'L\'adresse e-mail est requise.',
            'email.email' => 'L\'adresse e-mail doit être valide.',

            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        $compte = UtilisateurPrincipale::find($id);

        if(!$validated['password']) {
            $compte->nom = $validated['nom'];
            $compte->prenom = $validated['prenom'];
            $compte->email = $validated['email'];
        } else {
            $compte->nom = $validated['nom'];
            $compte->prenom = $validated['prenom'];
            $compte->email = $validated['email'];
            $hashedPassword = Hash::make($validated['password']);
            $compte->password = $hashedPassword;
        }
        
        if($this->emailExisteDeja($validated['email'])) 
            return redirect()->back()->with([
                'create' => true,
                'status' => 'exist'
            ]);

        try {
            if($compte->save()) {
                if($validated['password']) {
                    try {
                        Mail::to($validated['email'])->send(new UpdateAccMail([
                            'nom' => $validated['nom'],
                            'prenom' => $validated['prenom'],
                            'password' => $validated['password'],
                        ]));
                        return redirect(route('compte.details'))->with([
                            'create' => true,
                            'status'=> 'success0'
                        ]);
                    } catch(\Exception $e) {
                        return redirect()->back()->with([
                            'create' => true,
                            'status' => 'emailError'
                        ]);
                    }
                }
                return redirect(route('compte.details'))->with([
                    'create' => true,
                    'status'=> 'success1'
                ]);
            }
        } catch(QueryException $e) {
            if($e->errorInfo[1] == 1061) {
                return redirect()->back()->with([
                    'create' => true,
                    'status'=> 'unique'
                ]);
            }
            return redirect()->back()->with([
                'create' => true,
                'status'=> 'failed'
            ]);
        }
    }

    public function delete($id) {
        if($this->test_connection()) return $this->test_connection();
        $compte = UtilisateurPrincipale::find($id);
        try {
            if($compte->delete()) 
                return redirect()->back()->with([
                    'delete' => true,
                    'status' => 'success'
                ]);
        } catch(QueryException $e) {
            return redirect()->back()->with([
                'delete'=> true,
                'status' => 'error'
            ]);
        }
    }


    public function account_details($id) {
        if($this->test_connection()) return $this->test_connection();

        $compte = UtilisateurPrincipale::find($id);

        $query = Utilisateur::query();

        $users = $query->where('utilisateurs.user_principale_id', $compte->user_principale_id)
                        ->get();
        $usersNumber = $users->count();

        $query = CarteSIm::query();
        $cartes = $query->where('carte_sim.user_principale_id', $compte->user_principale_id)
                        ->orWhereIn('carte_sim.user_id', function ($subQ) use ($compte) {
                            $subQ->select('user_id')
                                ->from('utilisateurs')
                                ->where('user_principale_id', $compte->user_principale_id);
                        })->get();
        $cartesNumber = $cartes->count();

        $query = CarteSImBlr::query();
        $cartesBlr = $query->where('carte_sim_blr.liee_par', $compte->user_principale_id)
                        ->get();
        $cartesBlrNumber = $cartes->count();

        return view('admin.details', [
            'compte' => $compte,
            'usersNumber' => $usersNumber,
            'users' => $users,
            'cartesNumber' => $cartesNumber,
            'cartesSim' => $cartes,
            'cartesBlrNumber' => $cartesBlrNumber,
            'cartesBlr' => $cartesBlr
        ]);
    }
}