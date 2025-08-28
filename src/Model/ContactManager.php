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

    public function findById(int $id) : ?Contact
    {
        $contactStmt = $this->pdo->prepare('SELECT * FROM contact WHERE contact_id = :id');
        $contactStmt->execute(['id' => $id]);
        
        $contact = $contactStmt->fetch(PDO::FETCH_ASSOC);

        if (!$contact) {
            return null;
        }

        return new Contact(
            $contact['contact_id'] ?? null,
            $contact['name'] ?? null,
            $contact['email'] ?? null,
            $contact['phone_number'] ?? null
        );
    }
}
