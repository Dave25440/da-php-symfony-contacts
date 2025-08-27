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

$db = new DBConnect();
$pdo = $db->getPDO();

var_dump($pdo);

$contactManager = new ContactManager($pdo);
$contacts = $contactManager->findAll();

while (true) {
    $line = readline("Entrez votre commande : ");
    echo "Vous avez saisi : $line\n";

    switch ($line) {
        case 'list':
            echo "Affichage de la liste\n";
            break;
        default:
            echo "Commande inconnue\n";
    }
}
