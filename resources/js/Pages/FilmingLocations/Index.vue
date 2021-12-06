<template>
    <app-layout>
        <div class="px-3 py-3 bg-white shadow mx-auto flex flex-row-reverse" style="width: fit-content; ">
            <div class="px-3 text-gray-700 flex flex-col" style="width: 80vw">
                <h1 v-if="arrondissement_current == 'Tout'" class="text-xl font-bold text-gray-700 uppercase text-center pb-3">Lieux de tournages à Paris - Page {{filming_locations.current_page}}/{{filming_locations.last_page}}</h1>
                                <h1 v-else class="text-xl font-bold text-gray-700 uppercase text-center pb-3">Lieux de tournages dans le {{remplaceur(arrondissement_current, 7500, 750, '')}} à Paris - Page {{filming_locations.current_page}}/{{filming_locations.last_page}}</h1>
                <span v-if="arrondissement_current == 'Tout'" class="uppercase text-gray-700 font-bold text-center text-sm">{{filming_locations.total}} lieux de tournages au total à Paris</span>
                <span v-else class="uppercase text-gray-700 font-bold text-center text-sm">{{filming_locations.total}} lieux de tournages au total dans le {{remplaceur(arrondissement_current, 7500,750, '')}}</span>

                <!-- Menu pour filtrer -->
                <div class="flex justify-center items-center">
                    <span>Trier les lieux de tournages par localité</span>
                    <select class="ml-3" v-model="arrondissement_current" @change="filterByArrondissement($event)">
                        <option v-for="arr in arrondissements" :key="arr" :value="arr">{{ remplaceur(arr, 7500, 750, '') }}</option>
                    </select>
                </div>          
                <div class="filming_locations-list flex flex-col mx-auto w-full">
                    <div class="flex flex-row w-full mt-3 text-sm uppercase">
                        <span class="w-1/6 p-3 bg-gray-700 text-white font-bold border-r border-gray-100 text-center">Nom de tournage</span>
                        <span class="w-40 p-3 bg-gray-700 text-white font-bold border-r text-center">Type</span>
                        <span class="w-20 p-3 bg-gray-700 text-white font-bold border-r text-center">Année</span>
                        <span class="w-1/6 p-3 bg-gray-700 text-white font-bold border-r text-center">Realisateur(s)</span>
                        <span class="w-1/6 p-3 bg-gray-700 text-white font-bold border-r text-center">Producteur(s)</span>
                        <span class="w-1/6 p-3 bg-gray-700 text-white font-bold border-r text-center">Adresse du lieu</span>
                        <span class="p-3 bg-gray-700 text-white font-bold text-center flex-grow">Actions</span>
                    </div>
                    
                    <div class="filming_location" v-for="filming_location in filming_locations.data" :key="filming_location">
                        <div class="flex flex-row w-full text-sm">
                            <span class="p-3 w-1/6 border-r border-l border-b flex items-center">{{filming_location.nom_tournage}}</span>

                            <span class="w-40 p-3 border-r border-b flex items-center ">{{filming_location.type_tournage}}</span>
                            <span class="w-20 p-3 border-r border-b flex items-center ">{{filming_location.annee_tournage}}</span>
                            <span class="w-1/6 p-3 border-r border-b flex items-center ">{{filming_location.nom_realisateur}}</span>
                            <span class="w-1/6 p-3 border-r border-b flex items-center ">{{filming_location.nom_producteur}}</span>
                            <span class="w-1/6 p-3 border-r border-b flex items-center ">{{filming_location.adresse_lieu}}</span>

                            <span class="border-r border-b flex justify-end flex-grow">
                                <div class="flex flex-row mr-3" style="width:fit-content">
                                    <button type="button" class="mx-auto m-3 mr-3 block p-3 uppercase text-xs font-bold text-white bg-gray-700 hover:bg-gray-500 focus:outline-none" @click="toggleShowAddResponse(filming_location,index)">Modifier</button>
                                    <button type="button" class="mx-auto m-3 mr-3 block p-3 uppercase text-xs font-bold text-white bg-red-700 hover:bg-red-500 focus:outline-none" @click="toggleShowAddResponse(filming_location,index)">Supprimer</button>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="my-4 text-center">
                    <Link :data="{'arrondissement_current' : arrondissement_current}" :href="link.url|| ''" v-for="link in filming_locations.links" v-bind:key="link.label">
                        <span v-bind:class="{ 'bg-gray-700': link.active, 'text-white': link.active }" class="inline-block bg-gray-200 p-3 m-1 rounded hover:bg-gray-500 " v-html="link.label"></span>
                    </Link>
                </div>
            </div>   
        </div>
    </app-layout>
</template>

<script>
    import { Head, Link } from '@inertiajs/inertia-vue3';

import AppLayout from '@/Layouts/AppLayout'
export default {
    props: {
        filming_locations: Object,
        arrondissement_current: String
    },
    components: { AppLayout, Link, Head},
    data() { 
        return {
            loading: false,
            filming_locations: this.filming_locations,
            arrondissements: {
                0: "Tout", 1: "75001", 2: "75002", 3: "75003", 4: "75004", 5: "75005", 6: "75006", 7: "75007", 8: "75008", 9: "75009", 
                10: "75010", 11: "75011", 12: "75012", 13: "75013", 14: "75014", 15: "75015", 16: "75016", 17: "75017", 18: "75018", 19: "75019", 20: 
                "75020", 21: "75116", 22: "93200", 23: "93500", 24: "94320"
            },
            arrondissement_current: this.arrondissement_current ,
    
        };
    },
    
    methods: {
        // Fonction pour convertir une date et renvoyer sous une forme francophone
        convertDate(inputFormat) {
            var d = new Date(inputFormat)
            return [this.pad(d.getDate()), this.pad(d.getMonth()+1), d.getFullYear()].join('/')
        },
        pad(s) { return (s < 10) ? '0' + s : s; },
        
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
        },
        filterByArrondissement(event) {
            let arrondissement_current = { 'arrondissement_current': event.target.value }
            this.$inertia.post(route('filming.list'), 
            arrondissement_current, 
            { 
                preserveScroll: true,
                resetOnSuccess: false,
                preserveState: false
            }
            );
        }, 
        
    },
    mounted() {
        console.dir(this.filming_locations)
    }
    
}
</script>
<style scoped>
    .bg-gray-400 {
        --tw-bg-opacity: 1;
        background-color: rgba(156, 163, 175, var(--tw-bg-opacity));
    }
    .bg-gray-300 {
        --tw-bg-opacity: 1;
        background-color: rgba(209, 213, 219, var(--tw-bg-opacity));	    
    }
    .bg-gray-700 {
        background-color: #4a5568;
        background-color: rgba(74, 85, 104, var(--tw-bg-opacity));
    }
    
    
    .filming_location:nth-child(2n+1) {
        background-color: rgba(209, 213, 219, var(--tw-bg-opacity));	    
    }
    
    
    .filming_location:nth-child(2n) {
        background-color: rgba(156, 163, 175, var(--tw-bg-opacity));
    }
    
</style>