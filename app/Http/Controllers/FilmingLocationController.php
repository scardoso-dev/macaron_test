<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\FilmingLocation;
use Illuminate\Support\Facades\Auth;

class FilmingLocationController extends Controller
{
    /**
     * Fonction qui renvoie la vue des lieux de tournages
     * @param Request $request
     * @return Inertia::render Vue des lieux de tournages avec un envoie de données
     */
    public function index(Request $request) {
        $user = Auth::user();
        if(isset($request->arrondissement_current) AND $request->arrondissement_current != null AND $request->arrondissement_current != 'Tout' ) {
                $arrondissement_current = $request->arrondissement_current;
                $filming_locations = FilmingLocation::where('ardt_lieu', '=', $arrondissement_current)->paginate(30);
        }
        else {
            $arrondissement_current = 'Tout';
            $filming_locations = FilmingLocation::paginate(30);
        }

        // Pour les requêtes de type 'post'
        if(count($request->post())){
          $arrondissement_current = $request->input('arrondissement_current');
        }
        if($user) {
            // Liste des lieux de tournages selon l'arrondissement sélectionné
            if ($arrondissement_current != 'Tout') {
                $filming_locations = FilmingLocation::where('ardt_lieu', '=', $arrondissement_current)->paginate(30);
                $filming_locations->withPath("/filming-locations?$arrondissement_current");
            }
            return Inertia::render('FilmingLocations/Index', compact('filming_locations', 'arrondissement_current'));
        }
    }
}
