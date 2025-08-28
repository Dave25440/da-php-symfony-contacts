<?php

namespace App\Command;

use PDO;
use App\Model\ContactManager;

class Command
{
    private PDO $pdo;
    private ContactManager $contactManager;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->contactManager = new ContactManager($this->pdo);
    }

    public function list() : void
    {
        $contacts = $this->contactManager->findAll();

        if (empty($contacts)) {
            echo "Aucun contact trouvé\n";
        } else {
            foreach ($contacts as $contact) {
                echo $contact, "\n";
            }
        }
    }

    public function detail(int $id) : void
    {
        $contact = $this->contactManager->findById($id);

        if ($contact === null) {
            echo "Contact introuvable\n";
        } else {
            echo $contact, "\n";
        }
    }
}
