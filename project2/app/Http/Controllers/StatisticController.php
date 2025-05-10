<?php

namespace App\Http\Controllers;

use App\Models\CarteSIm;
use App\Models\CarteSImBlr;
use App\Models\Equipement;
use App\Models\UtilisateurPrincipale;
use App\Models\Vehicule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    public function index() {
        if(!auth()->guard('admin')->check()) return redirect(route('auth.login'));
        $query = UtilisateurPrincipale::query();
        $numOfAcc = $query->count();

        $query = CarteSIm::query();
        $numOfSim  = $query->count();

        $query = CarteSImBlr::query();
        $numOfBlr = $query->count();

        $query = Vehicule::query();
        $numOfVehicule = $query->count();

        $query = Equipement::query();

        $ports = DB::table('equipements as e')
                    ->join('carte_sim_blr as b', 'e.equipement_id', '=', 'b.equipement_id')
                    ->select('e.name', 'e.nombre_port', DB::raw('COUNT(*) as total_cards'))
                    ->groupBy('e.name', 'e.nombre_port')
                    ->get();

        $data = [
            'countAcc' => $numOfAcc,
            'countSim' => $numOfSim,
            'numOfBlr' => $numOfBlr,
            'countVehi' => $numOfVehicule,
            'ports' => $ports
        ];

        return view('admin.dashboard', ['data' => $data]);
    }
}
