<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Utilisateur;
use App\Models\UtilisateurPrincipale;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function existMail($mail) {
        return UtilisateurPrincipale::where("email", $mail)->exists() ||
                            Utilisateur::where("email", $mail)->exists();
    }

    public function info() {
        if(!auth()->guard("admin")->check()) 
            return redirect(route('auth.login'));

        $admin = Admin::find(auth()->guard('admin')->id());
        return view('admin.profile-info', ['admin' => $admin]);
    }

    public function update_admin(Request $request)  {

        if($request->input('reset') == 'reset')
            return redirect(route('admin.dashboard'));

        if(!auth()->guard("admin")->check()) 
            return redirect(route('auth.login'));

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

        $admin = Admin::find(auth()->guard('admin')->id());

        if(!$validated['password']) {
            $admin->nom = $validated['nom'];
            $admin->prenom = $validated['prenom'];
            $admin->email = $validated['email'];
        } else {
            $admin->nom = $validated['nom'];
            $admin->prenom = $validated['prenom'];
            $admin->email = $validated['email'];
            $hashedPassword = Hash::make($validated['password']);
            $admin->password = $hashedPassword;
        }

        if($this->existMail($validated['email'])) 
            return redirect()->back()->with([
                'create' => true,
                'status' => 'exist'
            ]);
        
        try {
            if($admin->save())
            session(['name' => $admin->prenom]);
                return redirect()->back()->with([
                    'create' => true,
                    'status'=> 'success'
                ]);
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
}
