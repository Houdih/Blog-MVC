<?php

namespace App\Src\Controller;

use App\Core\BaseController;
use App\Src\Entite\User;
use App\Src\Modele\UserModele;

class UserController extends BaseController
{
    public function index()
    {
        $user = new UserModele();
        $users = $user->findAll();
        return $this->render('user/index', compact('users'));
    }

    public function profil($id)
    {
        $userModele = new UserModele();
        $user = $userModele->findById($id);
        return $this->render('user/profil', compact('user'));
    }

    public function login()
    {
        $user = new UserModele();
        $user->login();
        return $this->render('user/login', []);
    }

    public function logout()
    {
        unset($_SESSION['user']);
        header('Location: /');
        exit;
    }

    public function read(int $id)
    {
        $userModele = new UserModele();
        $user = $userModele->findById($id);
        return $this->render('user/read', compact('user'));
    }

    public function create()
    {
        $user = new UserModele();
        $user->add();
        return $this->render('user/register', []);
    }

    public function update()
    {
        $userModele = new UserModele();
        $userModele->edit();
        return $this->render('user/update', []);
    }

    public function delete($id)
    {
        $userModele = new UserModele();
        $userModele->delete($id);
        session_destroy();
        header('Location: /');
    }
    

}