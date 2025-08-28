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

    public function create(string $name, string $email, string $phoneNumber) : void
    {
        if (empty(trim($name)) || empty(trim($email)) || empty(trim($phoneNumber))) {
            echo "Erreur : tous les champs sont requis\n";
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Erreur : email invalide\n";
            return;
        }

        try {
            $this->contactManager->addContact($name, $email, $phoneNumber);
            echo "Contact ajouté avec succès\n";
        } catch (\Exception $e) {
            echo $e->getMessage() . "\n";
        }
    }
}
