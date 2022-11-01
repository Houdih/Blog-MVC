<?php

namespace App\Core;

use App\Src\Controller\HomeController;
use Error;
use App\Src\Exception\ViewNotFoundException;

/**
 * Classe Router Scinde l'uri en segment afin d'appeler le bon controller avec l'action et les parametres associés éventuelle
 */
class Router 
{

    /**
     * Nom du controller, correspond au 1er index de l'uri. e.g '/user'
     * @var string 
     */
    private $controller;

    /**
     * Nom de la method du controller, correspond au 2eme index de l'uri. e.g '/user/edit' -> 'edit'
     * @var null|string
     */
    private $action;

    /**
     * Paramètre passé à la method du controller, correspond au 3eme index de l'uri. e.g '/user/edit/5' -> '5'
     * @var null|string
     */
    private $param;

    public function __construct(string $uri)
    {
        // On démarre une nouvelle session
        session_start();

        $uri = explode('/', trim($uri, '/')); // e.g [0]=>'user' [1]=>'edit' [2]=>'5'

        $this->controller = !empty($uri[0]) ? $uri[0] : 'home';
        $this->action = $uri[1] ?? 'index';
        $this->param = $uri[2] ?? null;
    }


    /**
     * @return  string
     */ 
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * @return  null|string
     */ 
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return  null|string
     */ 
    public function getParam()
    {
        return $this->param;
    }


    public function run()
    {
        // On récupère le 1er index de l'uri. e.g 'user'
        $controllerName = $this->getController();
        // On concatène à 'Controller'. e.g 'UserController'
        $controllerClassName = '\\App\\Src\\Controller\\' . ucfirst(strtolower($controllerName)) . 'Controller';

        // On vérifie si la classe du controller existe
        if(class_exists($controllerClassName))
        {
            // Puis on l'instancie
            $controller = new $controllerClassName();

            // On appelle l'action. e.g 'edit'
            $action = $this->getAction();
            
            // On vérifie que l'action (la method du controller) existe
            if(method_exists($controller, $action))
            {
                // Avec des parametres associé, afin d'appeler le tout
                $controller->$action($this->getParam());
            }
            else {
                http_response_code(404);
                echo "La page recherchée n'existe pas";
            }
        }
        else {
            header("Status: 301 Moved Permanently", false, 301);
            header('Location: /');
        }
    }
}