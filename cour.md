## Modèles, migrations et controllers 

Pour permettre à l'utilisateur de poster des commentaires, on aura besoin d'un(e):

- modèle : qui nous fournit un moyen simple d'interagir avec la BDD 
- migration : qui nous permet de facilement créer et modifier les tables de notre BDD 
- controller : responsable de traiter les requêtes de renvoyer les réponses 

## Middleware 
Un middleware est une fonctionnalité permettant de filtrer les requêtes HTTP effectuées dans l'application. Les middlewares sont des couches intermédiaires qui peuvent êtres ajoutées au pipeline de traitement des requêtes HTTP pour effectuer des tâches spécifiques avant que la requête n'atteigne la route appropriée ou après que la réponse ait été générée par la controleur.

## Installation de breeze 

bash : `composer require laravel/breeze --dev`
Ensuite `php artisan breeze:install` -> blade -> yes -> entrer 

Un système d'authentification a été crée avec un login et un register. Il faut ensuite envoyer les données vers la vase de donnée avec un `php artisan migrate`

## Les composants
### composants sous forme de classes 
composants les plus versatiles et robuste qui peuvent prendre des paramètres 

### composants anonymes 
composants simples ne prennant aucun paramètre

## Fonctions d'aide Laravel
`route()` : fonction qui génère l'URL correspondant à une route nommée `{{route('chirps.index')}}`
`action()` : fonction qui génère l'URL correspondant à l'action d'un contrôleur donné `{{action([ChirpsController::class, index])}}`
`url()` : fonction qui génère l'URL complète

`__()` : fonction qui renvoie la traduction pour une chaîne de caractère donnée

`session()` : Fonction qui récupère les données de session

`setLocale()` : Fonction qui change la langue de l'application

## Langage 
Pour avoir les textes en une autre langue 
`php artisan lang:publish`
Ensuite : app/Config/app.php et y modifier le local 'en' en 'fr' puis fermer
Aller dans le dossier lang, dupliquer le dossier 'en' et renommé la copie en 'fr'.
Changer enfin le contenu de 'auth' en français

<!-- Knowing is not enough; we must apply. Being willing is not enough; we must do. - Leonardo da Vinci -->

## Ajouter des données / des colonnes à une table
`php artisan make:migration add_user_id_and_message_to_chirps` : va créer un nouvelle migration  pour ajouter des colonnes
Dans le fichier on aura 'schema::table'
```php
    $table->foreignId('user_id')->constrained()->cascadeOnDelete()->after('id');
    $table->string('message')->after('user_id');
```

## Mass assignation
Permet de définir plusieurs attributs d'un modèle en une seule fois. Par exemple, imaginez que vous avez un modèle `Utilisateur` avec des champs tels que `nom`, `email` et `rôle`. La mass assignation permet de définir tous ces champs en une fois, ce qui peut être très pratique et vous faire gagner du temps. 
Cependant, si elle n'est pas gérée avec précaution, la mass assignation peut entraîner une vulnérabilité de sécurité appelée "over-posting" ou "vulnérabilité de mass assignation"