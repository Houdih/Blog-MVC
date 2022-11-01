<?php

namespace App\Core;

use App\Src\Exception\ViewNotFoundException;

class BaseController
{
    /**
     * Methode render() permet de renvoyer une vue avec les données
     *
     * @param string $path
     * @param array $data
     * @return void
     */
    public function render(string $path, array $data = [])
    {
        // Si le fichier existe
        if(file_exists('../Template/' . $path . '.php'))
        {
            // On extrait le contenu de $data
            extract($data);

            // On démarre le buffer de sortie
            ob_start();

            // On cée le chemin vers la vue
            require_once '../Template/' . $path . '.php';

            // Transfert le buffer dans $content
            $content = ob_get_clean();

            // Template de base
            require_once '../Template/Layout.php';
        }
        else {
            throw new ViewNotFoundException();
        }
    }
}