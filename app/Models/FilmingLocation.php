<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilmingLocation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'annee_tournage',
        'coord_y',
        'coord_x',
        'type_tournage',
        'nom_producteur',
        'nom_tournage',
        'nom_realisateur',
        'adresse_lieu',
        'id_lieu',
        'ardt_lieu',
        'date_fin',
        'date_debut',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        
    
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
    ];


}
