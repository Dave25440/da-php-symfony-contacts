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
use App\Command\Command;

$db = new DBConnect();
$pdo = $db->getPDO();

$command = new Command($pdo);

while (true) {
    $line = readline("Entrez votre commande : ");
    echo "Vous avez saisi : $line\n";

    switch ($line) {
        case 'list':
            $command->list();
            break;
        default:
            echo "Commande inconnue\n";
    }
}
