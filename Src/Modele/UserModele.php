<?php

namespace App\Src\Modele;

use App\Core\BaseForm;
use App\Core\BaseManager;
use App\Core\Db;
use App\Src\Entite\User;

class UserModele extends BaseManager
{
    protected $table;
    protected $db;

    public function __construct()
    {
        $this->table = 'user';
        $this->db = Db::getInstance();
    }

    /**
     * Connecte l'utilisateur et demarre une session
     * @return void
     */
    public function login()
    {
        if(BaseForm::validate($_POST, ['mail', 'pass']))
        {
            $mail = htmlentities($_POST["mail"], ENT_QUOTES);
            $pass = htmlentities($_POST['pass'], ENT_QUOTES);
            
            // On prépare une requête afin de récupèrer l'utilisateur
            $req = $this->requete('SELECT * FROM user WHERE mail = :mail', [
                "mail" => $mail
            ]);
            $userData = $req->fetch();

            if($userData)
            {
                // On vérifie que les 'pass' correspondent
                if(password_verify($pass, $userData->pass))
                {
                    // On instancie notre utilisateur tout en hydratant avec les données
                    $user = new User($userData);
                    
                    // On lui demarre une session
                    $_SESSION['user'] = $user;
                    
                    // On le dirige vers son profil
                    header('Location: /user/profil/'. $user->getId());
                    exit;
                    
                }
                else {            
                    echo "Le mail et/ou le mot de passe est incorrect";
                    header('Location: /user/login');
                    exit;
                }
            }
            else {            
                echo "Le mail et/ou le mot de passe est incorrect";
                header('Location: /user/login');
                exit;
            }
        }
    }

    /**
     * Methode pour ajouter un utilisateur 
     *
     * @return void
     */
    public function add()
    {
        // On verifie si le formulaire est valide
        if(BaseForm::validate($_POST, ['mail', 'pass', 'pseudo']))
        {
            // Convertit tous les caractères éligibles en entités HTML pour prévenir des faille XSS
            $mail = htmlentities($_POST["mail"], ENT_QUOTES);
            $pass = htmlentities($_POST['pass'], ENT_QUOTES);
            $pseudo = htmlentities($_POST['pseudo'], ENT_QUOTES);
            
            // Vérifie si le mail n'existe pas déjà en bdd
            $reqMail = $this->requete('SELECT mail FROM user WHERE mail= :mail', [
                "mail" => $mail
            ]);

            if($reqMail->fetch()) {
                echo "Le mail existe déjà";
            } 
            else {
                // On hache le mdp de l'utilisateur
                $pass = password_hash($pass, PASSWORD_DEFAULT);

                // On PREPARE notre requête puis l'EXECUTE dans un tableau d'option 
                $this->requete("INSERT INTO user(mail, pass, pseudo, roles) VALUES(:mail, :pass, :pseudo, :roles)", [
                    'mail' => $mail,
                    'pass' => $pass,
                    'pseudo' => $pseudo,
                    'roles' => '["ROLE_USER"]'
                ]);

                // On le connecte 
                $this->login();
            }
        }
    }

    public function edit()
    {
        if(isset($_SESSION['user']) && !empty($_SESSION['user']->getId()))
        {
            if(BaseForm::validate($_POST, ['mail', 'pass', 'newPass', 'pseudo']))
            {
                $mailUp = htmlentities($_POST["mail"], ENT_QUOTES);
                $pass = htmlentities($_POST['pass'], ENT_QUOTES);
                $newPass = htmlentities($_POST['newPass'], ENT_QUOTES);
                $pseudo = htmlentities($_POST['pseudo'], ENT_QUOTES);

                $id = $_SESSION['user']->getId();
                $mailSession = $_SESSION['user']->getMail();


                // On fait une requête pour vérifier le mail
                $reqMail = $this->requete('SELECT mail FROM user WHERE mail = :mail', [
                    "mail" => $mailUp
                ]);

                // Si le mail entré existe en bdd et qu'il soit different de l'utilisateur courrant
                if($reqMail->fetch()->mail && !$mailSession)
                {
                    echo "Le mail existe déjà";
                    header('Location: /');
                }
                else 
                {
                    // On Récupère le mdp de l'utilisateur courrant
                    $reqPass = $this->requete('SELECT pass FROM user WHERE id = :id', [
                        "id" => $id
                    ]);
                    $reqPass = $reqPass->fetch()->pass;
                    
                    // Si le mdp correspond à celui en bdd et celui envoyé par l'user
                    if(password_verify($pass, $reqPass))
                    {
                        // On hache le nouveau mdp
                        $newPass = password_hash($newPass, PASSWORD_DEFAULT);

                        // On modifie les champs
                        $this->requete('UPDATE user SET mail = :mail, pass = :pass, pseudo = :pseudo WHERE id = :id', [
                            "mail" => $mailUp,
                            "pass" => $newPass,
                            "pseudo" => $pseudo,
                            "id" => $id
                        ]);                   
                    } 
                    else {
                        echo "Le mot de passe ne correspond pas";
                        header('Location: /');
                    }
                }

                header('Location: /user/profil/'. $_SESSION['user']->getId());
                exit;
            }              
        } 
    }
}