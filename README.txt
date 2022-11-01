Application web en PHP (Objet) avec le pattern MVC 

Seulement le système utilisateur est développé

Architecture :

    - Public -> Mon fichier index.php, de la ou demarre l'application. Ainsi que mes dossiers css, img, video...
    - Core -> Le coeur de l'application 
        . Router, qui interprete la REQUEST_URI afin d'instancier le controller, avec ses methods et paramètre eventuelle.
        . BaseController, qui permet de renvoyer les données à la bonne vue.
        . Db, represente l'instance unique de notre connexion à la bdd
        . BaseManager, possede des méthods générique pour les requêtes SQL
    
    - Controller -> Instancie le manager pour appelé la methode demandée et renvoie à la vue
    - Modèle -> S'occupe de Vérifier les données et de faire des requêtes SQL
    - Entity -> Les classes qui représentent les tables avec leurs champs correspondant à la bdd
    - Template -> C'est notre bloc Vue
    - Vendor -> Normalement contient les librairies externe, j'y ai placé mon autoloader