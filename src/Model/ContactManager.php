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

    public function addContact(string $name, string $email, string $phoneNumber): void
    {
        try {
            $insertContact = $this->pdo->prepare('INSERT INTO contact(name, email, phone_number) VALUES (:name, :email, :phone_number)');
            $insertContact->execute([
                'name' => $name,
                'email' => $email,
                'phone_number' => $phoneNumber,
            ]);
        } catch (\Exception $e) {
            error_log('Erreur d\'insertion : ' . $e->getMessage());
            throw new \Exception('Impossible d\'ajouter le contact.');
        }
    }

    public function modifyContact(int $id, string $name, string $email, string $phoneNumber): void
    {
        try {
            $updateContact = $this->pdo->prepare('UPDATE contact SET name = :name, email = :email, phone_number = :phone_number WHERE contact_id = :id');
            $updateContact->execute([
                'id' => $id,
                'name' => $name,
                'email' => $email,
                'phone_number' => $phoneNumber,
            ]);
        } catch (\Exception $e) {
            error_log('Erreur de mise à jour : ' . $e->getMessage());
            throw new \Exception('Impossible de modifier le contact.');
        }
    }

    public function removeContact(int $id): void
    {
        try {
            $deleteContact = $this->pdo->prepare('DELETE FROM contact WHERE contact_id = :id');
            $deleteContact->execute(['id' => $id]);
        } catch (\Exception $e) {
            error_log('Erreur de suppression : ' . $e->getMessage());
            throw new \Exception('Impossible de supprimer le contact.');
        }
    }
}
