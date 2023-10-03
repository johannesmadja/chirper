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
### composants sous forme de classes :
composants les plus versatiles et robuste qui peuvent prendre des paramètres 

### composants anonymes :
composants simples ne prennant aucun paramètre

## Fonctions d'aide Laravel
- `route()` : fonction qui génère l'URL correspondant à une route nommée `{{route('chirps.index')}}`
- `action()` : fonction qui génère l'URL correspondant à l'action d'un contrôleur donné `{{action([ChirpsController::class, index])}}`
  
- `url()` : fonction qui génère l'URL complète

- `__()` : fonction qui renvoie la traduction pour une chaîne de caractère donnée

- `session()` : Fonction qui récupère les données de session

- `setLocale()` : Fonction qui change la langue de l'application

- `auth()->user()` : permet de récupérer l'utilisateur connecté ou `Auth::user()`

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

## Crétion d'une policy 
bash : `php artisan make:policy namePolicy --model=chirp` Permet de définir des méthodes limitant ou donnant accès à des actions utilisateur
Nom par convention : nom du modèle préfixé de policy

Résume : 
Appelle du update à la soumission du formulaire -> validation , mise à jour et redirction vers la page 'index'
- Tous utilisateur peut modifier un commentaire même si celui ci n'est pas le sien
  -> Alors on crée une `policy` associé au model chirp. 
  -> Modification des méthodes 'viewAny' et 'update'
  -> Récupérer le commentaire associé à l'user et vérifier avec la méthode "is()" si les identifiants correspondent et que l'utilisateur est bien l'auteur du commentaire 
  -> Modifier le update dans le `ChirpController` afin d'effectuer une vérification avant de permettre la modification `$this->authorize('update', $chirp)`

- Cacher le bouton d'édition quand l'utilisateur n'est pas l'auteur du commentaire 
  -> Mettre le dropdown sous une condition `@if ($chirp->user->is(auth()->user()))`. La fonction `auth()` est une fonction d'aide de Laravel permettant de récupérer l'utilisateur associé
  -> Ajouté un petit tag "Modifié" si le commentaire est modifié en se servant d'une condition if?

- Supprimer un commentaire 
  -> Modifier la fonction destroy du Controller
  -> créer un formulaire avec une méthode 'delete'
  
## Les étapes de création d'une notification ( Envoi de notification )

1. Créer une notification (sms, email, slack...)
2. Créer un évènement
3. Dispatcher un évènement
4. Créer un Event Listener
5. Lier l'Event Listener à l'évènement créé 

bash : `php artisan make:notification NewChirp`
C'est une classe qui représente le mail en question.
Faire une injection d'une instance de Chirp dans la constructeur afin de  pourvoir l'utiliser dans la classe

**Créer un évènement** : `php artisan make:event ChirpCreatedEvent`
Faire une injection d'une instance de Chirp dans la constructeur afin de  pourvoir l'utiliser dans la classe

**Dispatcher un évènement**
 -> Dans le model : Ajouter la propriété `$dispatchesEvents` avec différents clés

    ```php
     protected $dispatchesEvents = [
        'created' => ChirpCreatedEvent::class, // Un évènement est automatiquement émis lorsqu'un  commentaire est crée
        // 'updated' => ,
        // 'deleted' => ,
    ]
    ```

**Créer un Event Listener**
-> Créer un écouteur d'évènement pour écouter l'évènement
bash : `php artisan make:listener SendChirpCreatedNotification --event=ChirpCreatedEvent` Elle viendra avec une méthode qui aura en paramètre l'évènemnt spécifié 'ChirpCreatedEvent'

-> Chercher le dossier 'Providers' et le fichier 'EventServiceProvider'. Modifier ce fichier [ propriété $listener ]. Il contient un tableau qui lie les évènements aux écouteurs d'évènement. On y ajoute notre évènement à son écouteur d'évènement

*La notification est envoyé depuis la méthode handle du fichier SendChirpCreatedNotification dans Listener 

-> Maintenant on doit pouvoir envoyer une notification à tous les utilisateurs sauf celui qui a écrit le commeentaire 

```tinker
User::where('id', '!=', '1')->get();

User::whereNot()
```

-> Aller ensuite dans app/Providers/EventServiceProvider.php 
On va y faire la liaison entre l'évènement et son écouteur d'évènement dans la tableau $listen

```php 
 protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        ChirpCreatedEvent::class => [
            SendChirpCreatedNotification::class,
        ],
    ];
```

## Envoi de mail 
Dans le Controller au niveau de la méthode store, on récupère le $request et on y applique la méthode notify. Penser à importer le trait notifiacation dans le model `use notification` 

-> Définir à qui seront envoyé les notifications 
Aller dans config->mail.php. On va y définir le service par lequel on veut envoyer notre notification
Trouvé la clé env('default' => 'smtp')
