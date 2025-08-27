<?php

spl_autoload_register(static function ($fqcn): void {
    $path = sprintf('%s.php', str_replace(['App\\Config', '\\'], ['config', '/'], $fqcn));
    require_once $path;
});

use App\Config\DBConnect;

$db = new DBConnect();
$pdo = $db->getPDO();

var_dump($pdo);

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
