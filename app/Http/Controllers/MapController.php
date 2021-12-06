<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class MapController extends Controller
{
    /**
     * Fonction qui retourne la page de la carte
     * @return Inertia::render Vue à l'aide d'inertia
     */
    public function index() {
        return Inertia::render('Map');
    }
}
