<?php

namespace App\Core;


class BaseManager extends Db
{
    /**
     * @var string Represente la table en bdd
     */
    protected $table;

    /**
     * @var Db Instance de notre connexion
     */
    protected $db;


/****************************************** CRUD GENERIQUE ******************************************/

    public function findAll()
    {
        $query = $this->requete("SELECT * FROM " . $this->table);
        return $query->fetchAll();
    }

    /**
     * Methode findById() Récupère via l'id, les champs d'une colonne d'une table 
     *
     * @param int $id
     */
    public function findById(int $id)
    {
        return $this->requete("SELECT * FROM {$this->table} WHERE id = $id")->fetch();
    }

    /**
     * Récupère un utilisateur à partir de son mail
     *
     * @param string $email
     * @return void
     */
    public function findOneByMail(string $mail)
    {
        return $this->requete("SELECT * FROM {$this->table} WHERE mail = ?", [$mail])->fetch();
    }

    public function delete($id)
    {
        return $this->requete("DELETE FROM {$this->table} WHERE id = ?", [$id]);
    }


    public function create()
    {
        $champs = [];
        $inter = [];
        $valeurs = [];

        // On boucle pour éclater le tableau
        foreach ($this as $champ => $valeur) {
            // INSERT INTO annonces (titre, description, actif) VALUES (?, ?, ?)
            if ($valeur !== null && $champ != 'db' && $champ != 'table') {
                $champs[] = $champ;
                $inter[] = "?";
                $valeurs[] = $valeur;
            }
        }

        // On transforme le tableau "champs" en une chaine de caractères
        $liste_champs = implode(', ', $champs);
        $liste_inter = implode(', ', $inter);

        // On exécute la requête
        return $this->requete('INSERT INTO ' . $this->table . ' (' . $liste_champs . ')VALUES(' . $liste_inter . ')', $valeurs);
        
    }

    public function update(int $id)
    {
        $champs = [];
        $valeurs = [];

        // On boucle pour éclater le tableau
        foreach ($this as $champ => $valeur) {
            // UPDATE annonces SET titre = ?, description = ?, actif = ? WHERE id= ?
            if ($valeur !== null && $champ != 'db' && $champ != 'table') {
                $champs[] = "$champ = ?";
                $valeurs[] = $valeur;
            }
        }
        $valeurs[] = $this->$id;

        // On transforme le tableau "champs" en une chaine de caractères
        $liste_champs = implode(', ', $champs);

        // On exécute la requête
        return $this->requete('UPDATE ' . $this->table . ' SET ' . $liste_champs . ' WHERE id = ?', $valeurs);
    }


    /**
     * Methode generique pour faire des requêtes simples et préparées.
     *
     * @param string $sql
     * @param array $attributs
     */
    public function requete(string $sql, array $attributs = null)
    {
        $this->db = Db::getInstance();
        // On vérifie si on a des attributs
        if (isset($attributs))
        {
            // On fait une requête préparée
            $query = $this->db->prepare($sql);
            $query->execute($attributs);
            return $query;
        } 
        else {
            // On fait une requête simple
            return $this->db->query($sql);
        }
    }

    /**
     * Hydrate (set) nos Entitées
     *
     * @param $data
     * @param object $object
     * @return void
     */
    public function hydrate($data, object $object)
    {
        foreach ($data as $key => $value) {
            // On récupère le nom du setter correspondant à la clé
            $setter = 'set' . ucfirst($key); // eamil -> setEmail

            // On vérifie si le setter existe
            if(method_exists($object, $setter)) {
                // On appelle le setter
                $object->$setter($value);
            }
        }
    }


}