<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\CarteSImBlr;
use App\Models\Equipement;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EquipementController extends Controller
{
    private function test_connection() {
        if (!auth()->guard('admin')->check()) {
            return redirect(route('auth.login'))->withErrors(['auth' => 'Authentication required']);
        }

        if (session()->has('guard')) {
            Auth::shouldUse(session('guard'));
        }
        return null;
    }

    public function create(Request $request) {
        if($this->test_connection()) return $this->test_connection();     

        $validated = $request->validate([
            'ip_address' => 'string|required|ip',
            'nombre_port' => 'string|required|regex:/^[0-9]+$/',
            'name' => 'required'
        ],[
            'name.required' => 'le nom d\'équipement est champ obligatoire',
            'ip_address.ip' => 'Le champ adresse IP doit contenir une adresse IP valide (exemple : 192.168.1.1)',
            'nbPorts.regex' => 'Le champ nombre de ports doit contenir uniquement des chiffres.',
            'ipAddress.required' => 'Adresse ip est un champ obligatoire',
            'nbPorts.required' => 'Nombre de ports est un champ obligatoire'
        ]);

        $admin = Admin::find(auth::guard('admin')->id());


        try {
            $equipement = $admin->equipements()->create($validated);
            if($equipement) {
                return redirect()->back()->with([
                    'submited' => true,
                    'status' => 'success'
                ]);
            }
        } catch (QueryException $e) {
            if($e->errorInfo[1] == 1062) 
                return redirect()->back()->with([
                    'submited' => true,
                    'error' => true
                ]);
            return redirect()->back()->with([
                'submited'=> true,
                'status' => 'failed'
            ]);
        }
    }

    public function displayEquipements() {
        if($this->test_connection()) return $this->test_connection();
        $equipements = Equipement::get(); //! maybe here also
        return view('details.equipementDet', ['equipements' => $equipements]);
    }

    public function equipement($id) {
        $equipement = Equipement::find($id);
        return view('admin.update', ['equipement'=> $equipement]);
    }

    public function update(Request $request, $id) {
        if($this->test_connection()) return $this->test_connection();
        $validated = $request->validate([
            'name' => 'required',
            'ipAddress' => 'string|required|ip',
            'nbPorts' => 'string|required|regex:/^[0-9]+$/'
        ],[
            'name.required' => 'nom d\'équipement est un champ obligatoire',
            'ipAddress.ip' => 'Le champ adresse IP doit contenir une adresse IP valide (exemple : 192.168.1.1)',
            'nbPorts.regex' => 'Le champ nombre de ports doit contenir uniquement des chiffres.',
            'ipAddress.required' => 'Adresse ip est un champ obligatoire',
            'nbPorts.required' => 'Nombre de ports est un champ obligatoire'
        ]);

        $equipement = Equipement::find($id);

        $equipement->name = $validated['name'];
        $equipement->ip_address = $validated['ipAddress'];
        $equipement->nombre_port = $validated['nbPorts'];

        try{
            if($equipement->save()){
                return redirect(route('consultation'))->with([
                    'status' => 'success',
                    'submited' => true
                ]);
            } else {
                return redirect(route('consultation'))->with([
                    'status'=> 'failed',
                    'submited' => true
                ]);
            }
        }catch(QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->withErrors([
                    'ipAddress' => 'Cette adresse IP existe déjà'
                ]);
            }
            return redirect(route('consultation'))->with('error', true);
        }
    }

    public function destroy($id) {
        if($this->test_connection()) return $this->test_connection();
        $equipement = Equipement::find($id);
        if($equipement->delete()) {
            return redirect()->back()->with([
                'status'=> 'success',
                'deleted' => true
            ]);
        } else {
            return redirect()->back()->with([
                'status'=> 'failed',
                'deleted' => true
            ]);
        }
    }

    public function deteils($id) {
        if($this->test_connection()) return $this->test_connection();
        $equipement = Equipement::find($id);

        $query = CarteSImBlr::query();

        $cartes = $query->where('carte_sim_blr.equipement_id', $equipement->equipement_id)
                        ->get();
        $numbers = $cartes->count();

        return view('admin.equipement', [
            'equipement' => $equipement,
            'numbers' => $numbers,
            'cartes' => $cartes
        ]);
    }
}
