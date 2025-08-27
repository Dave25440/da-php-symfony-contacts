<?php

namespace App\Command;

use PDO;
use App\Model\ContactManager;

class Command
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function list() : void
    {
        $contactManager = new ContactManager($this->pdo);
        $contacts = $contactManager->findAll();

        if (empty($contacts)) {
            echo "Aucun contact trouvé\n";
        } else {
            foreach ($contacts as $contact) {
                echo $contact, "\n";
            }
        }
    }
}
