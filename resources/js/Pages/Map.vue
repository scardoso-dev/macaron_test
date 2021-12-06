<template>
    <app-layout>
    <div class="px-3 py-3 bg-white shadow mx-auto flex flex-row-reverse" style="width: fit-content; ">
        <div class="px-3 text-gray-700 flex flex-col" style="width: 30vw">
            <h1 class="text-xl font-bold text-gray-700 uppercase text-center pb-3">Carte des lieux de tournages à Paris</h1>
            <!-- Menu pour trier par localité -->
            <div class="flex justify-center items-center">
                <span>Trier les lieux de tournages par localité</span>
                <select class="ml-3" v-model="arrondissement_places_to_display" @change="lieux_de_tournages_filtre">
                    <option v-for="arr in arrondissements" :key="arr" :value="arr">{{ remplaceur(arr, 7500, 750, '') }}</option>
                </select>
            </div>

            <!-- Menu pour afficher/désafficher les lieux sur la carte -->
            <div class="mt-3 flex justify-center items-center">
                <span>Afficher les lieux de tournages</span>
                <input class="ml-3" type="checkbox" id="checkbox" v-model="showPlaces">
                <label v-if="showPlaces" class="ml-1" for="checkbox">Oui</label>
                <label v-else class="ml-1" for="checkbox">Non</label>
            </div>
        </div>
        <!-- Loading de la map -->
        <div v-if="loading" class="text-2xl flex flex-col absolute text-gray-700 font-bold flex justify-center items-center border-2" style="height: 80vh; width: 80vw; z-index: 99; background-color: rgba(255,255,255,1)" >
            <span class="text-xl">Chargement de la carte...</span>
            <span class="mt-3 text-base">Veuillez patienter</span>
        </div>
        <div class="flex flex-col">
        <l-map style="height: 80vh; width: 50vw; z-index: 9" :zoom="zoom" :center="center" :maxZoom="16" :minZoom="12" :options="{zoomControl: false}">
            <l-tile-layer :url="url" :attribution="attribution"></l-tile-layer>
            <l-control-zoom position="bottomright"  ></l-control-zoom>
            <l-geo-json :geojson="geojson" :options="geojsonOptions" />
    
            <l-circle-marker v-for="feature in lieux_de_tournages" :key="feature" :lat-lng="feature.properties.geo_point_2d" :radius="2" :color="'red'" :visible="showPlaces">
                
                <l-popup>
                    <div class="text-gray-700 flex flex-col">
                        <span class="font-bold text-sm uppercase">Nom du tournage</span>  
                        <span>{{feature.properties.nom_tournage}}</span>
                    </div>
                    <div class="text-gray-700 flex flex-col mt-3">
                        <span class="font-bold text-sm uppercase">Type du tournage</span>  
                        <span> {{feature.properties.type_tournage}}</span>
                    </div> 
                    <div class="text-gray-700 flex flex-col mt-3">
                        <span class="font-bold text-sm uppercase">Année du tournage</span>  
                        <span> {{feature.properties.annee_tournage}}</span>
                    </div>   
                    <div class="text-gray-700 flex flex-col mt-3">
                        <span class="font-bold text-sm uppercase">Réalisateur</span>  
                        <span> {{feature.properties.nom_realisateur}}</span>
                    </div> 
                    <div class="text-gray-700 flex flex-col mt-3">
                        <span class="font-bold text-sm uppercase">Producteur</span>  
                        <span> {{feature.properties.nom_producteur}}</span>
                    </div> 
                    <div class="text-gray-700 flex flex-col mt-3">
                        <span class="font-bold text-sm uppercase">Date du tournage</span>  
                        <span>Du {{convertDate(feature.properties.date_debut)}} au {{convertDate(feature.properties.date_fin)}}</span>
                    </div>    
                    <div class="text-gray-700 flex flex-col mt-3">
                        <span class="font-bold text-sm uppercase">Adresse du lieu</span>  
                        <span> {{feature.properties.adresse_lieu}}</span>
                    </div>                                 
                </l-popup>
                
            </l-circle-marker>

        </l-map>
        <!-- Nombre de lieux de tournages selon la localité sélectionné -->
        <div class="font-bold uppercase flex justify-center">
            <span v-if="lieux_de_tournages_length > 1 && arrondissement_places_to_display.indexOf(750) != -1" class="mt-3">{{lieux_de_tournages_length}} lieux de tournages au total dans le {{remplaceur(arrondissement_places_to_display,7500,750, '')}} à Paris</span>
            <span v-else-if="lieux_de_tournages_length === 1 && arrondissement_places_to_display.indexOf(750) != -1 && arrondissement_places_to_display != 'Tout'" class="mt-3">{{lieux_de_tournages_length}} lieu de tournage au total dans le {{remplaceur(arrondissement_places_to_display,7500,750, '')}} à Paris</span>
            <span v-else-if="lieux_de_tournages_length > 1 && arrondissement_places_to_display.indexOf(750) == -1 && arrondissement_places_to_display != 'Tout'" class="mt-3">{{lieux_de_tournages_length}} lieux de tournages au total dans le {{remplaceur(arrondissement_places_to_display,7500,750, '')}} à Paris</span>
            <span v-else-if="lieux_de_tournages_length === 1 && arrondissement_places_to_display.indexOf(750) == -1 && arrondissement_places_to_display != 'Tout'" class="mt-3">{{lieux_de_tournages_length}} lieu de tournage au total dans le {{remplaceur(arrondissement_places_to_display,7500,750, '')}} à Paris</span>
            <span v-else-if="lieux_de_tournages_length > 1 && arrondissement_places_to_display === 'Tout'" class="mt-3">{{lieux_de_tournages_length}} lieux de tournages au total à Paris</span>
        </div>
        </div>
    </div>

    </app-layout>
</template>

<script>
// DON'T load Leaflet components here!
// Its CSS is needed though, if not imported elsewhere in your application.
import { LMap, LTileLayer, LGeoJson , LCircleMarker, LPopup, LControlZoom} from "@vue-leaflet/vue-leaflet";
import "leaflet/dist/leaflet.css"

import AppLayout from '@/Layouts/AppLayout'
export default {
    components: { LMap, LGeoJson, LTileLayer, LCircleMarker, LPopup, LControlZoom, AppLayout},
    data() { 
        return {
            loading: false,
            url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            attribution: '&copy; <a target="_blank" href="http://osm.org/copyright">OpenStreetMap</a> contributors',
            zoom: 13,
            geojson: null,
            lieux_de_tournages: null,
            lieux_de_tournages_all: null,
            lieux_de_tournages_length: -1,
            arrondissements: null,
            arrondissement_places_to_display: "Tout",
            showPlaces: true,
            geojsonOptions: {
            // Options that don't rely on Leaflet methods.
            },
            center: [48.8481591,2.3607152],
        };
    },
    async created() {
        this.loading = true;
        const response = await fetch('/geojson/arrondissements.geojson');
        this.geojson = await response.json();
        
        await axios.get('/geojson/lieux-de-tournage-a-paris.geojson')
        .then((response) => {
            this.lieux_de_tournages = response.data.features;
            this.lieux_de_tournages_all = response.data.features;
            let arrondissements =  this.lieux_de_tournages.map(item => item.properties.ardt_lieu)
            this.arrondissements = _.uniq(arrondissements).sort().filter(Boolean);
            this.arrondissements.unshift('Tout');
            this.lieux_de_tournages_length = response.data.features.length;
        })
        this.loading = false;
    },
    methods: {
        // Fonction pour convertir une date et renvoyer sous une forme francophone
        convertDate(inputFormat) {
            var d = new Date(inputFormat)
            return [this.pad(d.getDate()), this.pad(d.getMonth()+1), d.getFullYear()].join('/')
        },
        pad(s) { return (s < 10) ? '0' + s : s; },
        lieux_de_tournages_filtre() {
            if(this.arrondissement_places_to_display === 'Tout') {
                this.lieux_de_tournages = this.lieux_de_tournages_all;
                this.lieux_de_tournages_length = this.lieux_de_tournages.length;
            }
            else {
                const lieux = this.lieux_de_tournages_all.filter(() => true);
                const data = lieux.filter(item => item.properties.ardt_lieu === this.arrondissement_places_to_display)
                this.lieux_de_tournages = data;
                this.lieux_de_tournages_length = data.length;

            }
        },
        remplaceur(chaine, cas1, cas2, remplacement) {
            if(chaine.indexOf(cas1) != -1) {
                var str = chaine.replace(cas1, remplacement);
                if(str === "1") {
                    return str + 'er arrondissement';
                }
                return str + 'ème arrondissement';
            }
            else if(chaine.indexOf(cas2) != -1) {
                var str = chaine.replace(cas2, remplacement);
                return str + 'ème arrondissement';
            }
            return chaine;
        }
        
    }
}
</script>
<style >
.leaflet-popup-content-wrapper {
    text-align: center;
}
.flex-row-reverse {
    flex-direction: row-reverse;
}
</style>