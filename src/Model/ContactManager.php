<?php

namespace App\Model;

use PDO;

class ContactManager
{
    public function __construct(private PDO $pdo) {}

    public function findAll() : array
    {
        $contactsData = $this->pdo->query('SELECT * FROM contact')->fetchAll(PDO::FETCH_ASSOC);

        $contacts = [];

        foreach ($contactsData as $contact) {
            $contacts[] = new Contact(
                $contact['contact_id'] ?? null,
                $contact['name'] ?? null,
                $contact['email'] ?? null,
                $contact['phone_number'] ?? null
            );
        }

        return $contacts;
    }
}
