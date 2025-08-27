<?php

spl_autoload_register(static function ($fqcn): void {
    if (str_starts_with($fqcn, 'App\\Config')) {
        $path = sprintf('%s.php', str_replace(['App\\Config', '\\'], ['config', '/'], $fqcn));
    } else {
        $path = sprintf('%s.php', str_replace(['App', '\\'], ['src', '/'], $fqcn));
    }

    require_once $path;
});

use App\Config\DBConnect;
use App\Model\ContactManager;
use App\Model\Contact;

$db = new DBConnect();
$pdo = $db->getPDO();

while (true) {
    $line = readline("Entrez votre commande : ");
    echo "Vous avez saisi : $line\n";

    switch ($line) {
        case 'list':
            $contactManager = new ContactManager($pdo);
            $contacts = $contactManager->findAll();

            if (empty($contacts)) {
                echo "Aucun contact trouvé\n";
            } else {
                foreach ($contacts as $contact) {
                    echo $contact, "\n";
                }
            }

            break;
        default:
            echo "Commande inconnue\n";
    }
}
