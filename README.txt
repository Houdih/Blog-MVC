Partie BackEnd, Projet de fin d'année à Metz Numeric School c'est pourquoi la documentation 
est en francais et le reste (classes, methodes, attributs...) est en anglais.

Application web en PHP (Objet) avec le pattern MVC (Modele View Controller).

Architecture :

    - Public    -> Mon fichier index.php, de la ou demarre l'application. Ainsi que mes dossiers css, img, video...
    
    - Core      -> Le coeur de l'application ;
        . Router            : interprete la REQUEST_URI afin d'instancier le controller, avec ses methodes et paramètres eventuelles.
        . BaseController    : permet de renvoyer les données à la bonne vue.
        . Db                : represente l'instance unique de notre connexion à la bdd
        . BaseManager       : possède des méthodes génériques pour les requêtes SQL

    - Src       -> Dossier source ;
        . Controller        : Instancie le manager pour appelé la methode demandée et renvoie à la vue avec les données
        . Modèle            : S'occupe de Vérifier les données et de faire des requêtes SQL
        . Entity            : Les classes qui représentent les tables avec leurs champs correspondant à la bdd
        . Template          : C'est notre bloc Vue
        . Vendor            : Normalement contient les librairies externe, j'y ai placé mon autoloader

    - Template  -> Dossier View, affiche les vues

    - Vendor    -> Dossier pour les librairies tierces, mais j'ai seulement crée un autoloader simple pour charger automatiquement mes classes