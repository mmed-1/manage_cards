<?php

namespace App\Http\Controllers;

use App\Mail\CreationMail;
use App\Mail\UpdateAccMail;
use App\Models\Admin;
use App\Models\Utilisateur;
use App\Models\UtilisateurPrincipale;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

    public function testUnicite($email): bool {
        return Admin::where("email", $email)->exists() ||
                    UtilisateurPrincipale::where("email", $email)->exists();
    }

    public function save(Request $request) {
        if(!auth()->guard('user_principale')->check())
            return redirect(route('auth.login'));

        if(session()->has('guard'))
            Auth::shouldUse(session('guard'));

        $user = UtilisateurPrincipale::find(auth()->guard('user_principale')->id());

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

        if($this->testUnicite($validated['email']))
            return redirect()->back()->with([
                'create' => true,
                'status' => 'emailExist'
            ]);

        try {
            $user2 = $user->utilisateur()->create($validated);
            if($user2) {
                try {
                    Mail::to($validated['email'])->send(new CreationMail([
                        'nom' => $validated['nom'],
                        'prenom' => $validated['prenom'],
                        'password' => $validated['password'],
                    ]));
                    return redirect()->back()->with([
                        'create'=> true,
                        'status' => 'success'
                    ]);
                } catch(\Exception $e) {
                    return redirect()->back()->with([
                        'create' => true,
                        'status'=> 'emailError'
                    ]);
                }
            }
        } catch (QueryException $e) {
            if($e->errorInfo[1] == 1062) {
                return redirect()->back()->with([
                    'create'=> true,
                    'status'=> 'unique'
                ]);
            }
            return redirect()->back()->with([
                    'create'=> true,
                    'status'=> 'failed'
                ]);
        }
    }

    public function show(Request $request) {
        $search = $request->input('search');

        $query = Utilisateur::query();
        if($search) {
            $query->where(function ($q) use ($search) {
                $q->whereRaw("CONCAT(prenom, ' ', nom) LIKE ?", ["%$search%"])
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        $users = $query->paginate(10);

        $users->appends(['search' => $search]);
        return view('details.users', ['users' => $users]);
    }

    public function delete($id) {
        $user = Utilisateur::find($id);
        try {
            if($user->delete()) 
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

    public function display($id) {
        $user = Utilisateur::find($id);
        return view('user_principale.update', ['user'=> $user]);
    }

    public function update(Request $request, $id) {
        if(!auth()->guard('user_principale')->check())
            return redirect(route('auth.login'));
        
        if(session()->has('guard'))
            Auth::shouldUse(session('guard'));

        $validated = $request->validate([
            'nom' => 'string|required',
            'prenom' => 'string|required',
            'email' => 'required|email',
            'password'=> 'min:8|confirmed',
        ],[
            'nom.required' => 'Le nom est requis.',
            
            'prenom.required' => 'Le prénom est requis.',
            
            'email.required' => 'L\'adresse e-mail est requise.',
            'email.email' => 'L\'adresse e-mail doit être valide.',

            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);
        
        $user = Utilisateur::find($id);

        if(!$validated['password']) {
            $user->nom = $validated['nom'];
            $user->prenom = $validated['prenom'];
            $user->email = $validated['email'];
        } else {
            $user->nom = $validated['nom'];
            $user->prenom = $validated['prenom'];
            $user->email = $validated['email'];
            $hashedPassword = Hash::make($validated['password']);
            $user->password = $hashedPassword;
        }

        if($this->testUnicite($validated['email'])) 
            return redirect()->back()->with([
                'create' => true,
                'status' => 'exist'
            ]);
        
        try {
            if($user->save()) {
                if($validated['password']) {
                    try {
                        Mail::to($validated['email'])->send(new UpdateAccMail([
                            'nom' => $validated['nom'],
                            'prenom' => $validated['prenom'],
                            'password' => $validated['password'],
                        ]));
                        return redirect(route('users.details'))->with([
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
                return redirect(route('users.details'))->with([
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
}
