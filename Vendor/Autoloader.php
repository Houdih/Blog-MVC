<?php

namespace App;
/**
 * Charge les classes automatiquement
 */
class Autoloader
{
    static function register()
    {
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    /**
     * @param string $class On récupère la totalité du namespace de la classe concernée e.g (App\Src\Controller)
     * @return void
     */
    static function autoload($class)
    {
        $class = str_replace(__NAMESPACE__ . '\\', '', $class); // On retire App\ (Src\Controller)

        $class = str_replace('\\', '/', $class); // On remplace les \ par des /

        $fichier = '../' . $class . '.php'; // On resitue à la racine et on rajoute l'extension '.php'. e.g ../Src/Controller.php

        if(file_exists($fichier))
        {
            require_once $fichier;
        }
    }
}