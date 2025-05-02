<?php

namespace App\Http\Controllers;

use App\Mail\PasswordResetEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Il faut ajouter votre email',
            'password.required' => 'Password est un champ obligatoire'
        ]);
        // If this returns FALSE, the hash was NOT generated from "forzaInter".);

        if (Auth::guard('admin')->attempt($validated)) {
            $admin = Auth::guard('admin')->user();

            session([
                'name' => $admin->prenom,
                'guard' => 'admin'
            ]);

            return redirect(route('admin.home'));
        } elseif (Auth::guard('user_principale')->attempt($validated)) {
            $user_pri = Auth::guard('user_principale')->user();

            session([
                'name' =>  $user_pri->prenom,
                'guard' => 'user_principale'
            ]);

            return redirect(route('home'));
        } elseif (Auth::guard('user')->attempt($validated)) {
            $user = Auth::guard('user')->user();

            session([
                'name' => $user->prenom,
                'guard' => 'user'
            ]);
            return redirect(route('home'));
        }

        return redirect()->back()->with([
            'login' => true,
            'status' => 'failed'
        ]);
    }

    public function sendReset(Request $request)
    {

        $validated = $request->validate([
            'email' => 'required|email'
        ], [
            'email.required' => 'Veuillez fournir une adresse e-mail.',
            'email.email' => 'Veuillez entrer une adresse e-mail valide.'
        ]);

        try {
            Mail::to($validated['email'])->send(new PasswordResetEmail());
            return redirect()->back()->with([]);
        } catch (\Exception $e) {
            return redirect()->back()->with([]);
        }
    }

    public function reset(Request $request) {
        
    }
}
