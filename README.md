<h1 align="center">Macaron : Test Technique</h1>
</br>
</br>

## Frameworks & Librairies utilisés
- Vue.js 3 (Front-end)
- Laravel 8 (Back-end)
- Inertia.js (Back-end)
- tailwind (Front-end --- Framework CSS) 
- vue-leaflet (Front-end --- librairie pour la map)

## Prérequis et configuration
- Installer composer 
- Avoir nodeJS
- Configurer votre fichier .env => pour celà remplissez le .env.example et renommez-le en .env

### Liste des commandes (à exécuter une fois le dépot cloné)
- composer install
- npm install
- php artisan migrate:refresh --seed
- php artisan serve
- npm run watch

### Bon à savoir
<p align="justify">Lors de la migration de la base de données et du seeder celà peut prendre du temps puisqu'il y a près 9000 lieux de tournages à insérer.</p>
</br>

**Attention** 
<p align="justify">La page 'map' mets du temps à charger puisque ce sont tous les lieux de tournages qui sont affichés. </p>
<p align="justify">Le déplacement sur la carte peut être non optimisé lorsque tout les lieux sont affichés, c'est pourquoi il vaut mieux utilisé les flèches directionnelles pour se déplacer sur la carte et utiliser les boutons présents pour zoomer. En revanche quand c'est filtrer ça fonctionne correctement.</p>
<p align="justify">N'oublie pas que vous pouvez appuyer sur chaque point (lieu de tournage) pour qu'une pop-up s'ouvre affichant les informations du tournage.</p>

</br>

## Connexion et inscription 
### Incription
<p align="justify">L'inscription sur la plateforme est possible, toutefois celà est inutile puisqu'un compte à déjà été créé.</p>


### Connexion
#### Compte par défault
- email : test@test.fr
- mot de passe : test

### Conclusion
<p align="justify">La librairie vue-leaflet est vraiment simple à implémenter et la documentation est courte et intuitive, celà nous permets d'avoir un rapidement une version de ce que l'on souhaite implémenter. Toutefois, quand on a des milliers de choses à afficher (comme dans ce test technique) il est préférable d'utiliser une librairie plus optimisés, ou alors il faudrait se tourner vers du react car en faisant des v-for avec vue c'est très long à charger.</p>
</br>
