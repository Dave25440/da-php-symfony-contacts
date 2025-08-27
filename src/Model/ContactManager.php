<?php

namespace App\Model;

use PDO;

class ContactManager {
    public function __construct(private PDO $pdo) {}

    public function findAll() : Array
    {
        $contactsStmt = $this->pdo->prepare('SELECT * FROM contact');
        $contactsStmt->execute();
        $contacts = $contactsStmt->fetchAll(PDO::FETCH_ASSOC);

        var_dump($contacts);

        return $contacts;
    }
}
