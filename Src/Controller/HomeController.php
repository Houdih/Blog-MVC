<?php

namespace App\Src\Controller;

use App\Core\BaseController;

class HomeController extends BaseController
{
    /**
     * Renvoie la vue home
     * @return void
     */
    public function index()
    {
        return $this->render('home/index', []);
    }
}