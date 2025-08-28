<?php

namespace App\Config;

use PDO;
use PDOException;
use Exception;

class DBConnect
{
    private ?PDO $pdo = null;

    public function __construct(
        private string $host,
        private string $name,
        private int $port,
        private string $user,
        private string $password
    ) {}

    public function getPDO(): PDO
    {
        if ($this->pdo === null) {
            try {
                $this->pdo = new PDO(
                    'mysql:host='.$this->host.';dbname='.$this->name.';port='.$this->port.';charset=utf8',
                    $this->user,
                    $this->password,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
            } catch (PDOException $e) {
                error_log('Erreur de connexion PDO : ' . $e->getMessage());
                throw new Exception('Impossible de se connecter à la base de données.');
            }
        }

        return $this->pdo;
    }
}
