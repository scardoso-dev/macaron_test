<?php

namespace Database\Seeders;

use App\Models\FilmingLocation;
use Illuminate\Database\Seeder;

class FilmingLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $strJsonFileContents = file_get_contents("public/geojson/lieux-de-tournage-a-paris.geojson");
        $strJsonFileContents = json_decode($strJsonFileContents);
        foreach ($strJsonFileContents->features as $feature) {   
            // On ajoute un lieux de tournage seulement si tout les champs sont remplis 
            if( isset($feature->properties->nom_realisateur) && isset($feature->properties->nom_producteur) && isset($feature->properties->ardt_lieu)) {
                FilmingLocation::create([
                    'annee_tournage' => $feature->properties->annee_tournage,
                    'coord_y' => $feature->properties->coord_y,
                    'coord_x' => $feature->properties->coord_x,
                    'type_tournage' => $feature->properties->type_tournage,
                    'nom_producteur' => $feature->properties->nom_producteur,
                    'nom_tournage' => $feature->properties->nom_tournage,
                    'nom_realisateur' => $feature->properties->nom_realisateur,
                    'adresse_lieu' => $feature->properties->adresse_lieu,
                    'id_lieu' => $feature->properties->id_lieu,
                    'ardt_lieu' => $feature->properties->ardt_lieu,
                    'date_fin' => $feature->properties->date_fin,
                    'date_debut' => $feature->properties->date_debut
                ]);
            }
        }
    }
}
