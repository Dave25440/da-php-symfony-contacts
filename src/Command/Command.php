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

    public function delete(int $id) : void
    {
        $contact = $this->contactManager->findById($id);

        if ($contact === null) {
            echo "Contact introuvable\n";
            return;
        }

        try {
            $this->contactManager->removeContact($id);
            echo "Contact supprimé avec succès\n";
        } catch (\Exception $e) {
            echo $e->getMessage() . "\n";
        }
    }

    public function help(): void
    {
        echo <<<'EOD'
Entrez votre commande : aide

=== Commandes ===

help : affiche cette aide
list : liste les contacts
detail [id] : affiche un contact
create [name], [email], [phone number] : crée un contact
delete [id] : supprime un contact
quit : quitte le programme

Attention à la syntaxe des commandes, les espaces et virgules sont importants.

=== Affichage ===

Contact #id : name, Email : email, Téléphone : phone number

=== Exemples ===

Entrez votre commande : list
Contact #1 : Gandalf le gris, Email : gandalf@istari.com, Téléphone : 01013021
Contact #2 : Buffy Summer, Email : buffy@sunnydale.com, Téléphone : 01091901
Contact #3 : Hermione Granger, Email : hermione@magie.com, Téléphone : 19091979

Entrez votre commande : detail 1
Contact #1 : Gandalf le gris, Email : gandalf@istari.com, Téléphone : 01013021

Entrez votre commande : create David Horès, dhores@dev.com, 20250827
Contact ajouté avec succès

Entrez votre commande : delete 3
Contact supprimé avec succès

Entrez votre commande : quit
Au revoir


EOD;
    }
}
