<?php

namespace App\Core;

use PDO;
use PDOException;

class Db extends PDO
{
    /**
     * Instance unique de notre connexion
     * @var PDO
     */
    private static $instance;

    public function __construct()
    {
        $config = require_once '../Config/Connexion.php';
        $dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'];

        try {
            parent::__construct($dsn, $config['user'], $config['password']);
            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance(): self
    {
        if(self::$instance === null)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }
}