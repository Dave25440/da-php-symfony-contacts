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

    if ($line === 'list') {
        $command->list();
    } elseif (preg_match('/^detail\s+(\d+)$/', $line, $matches)) {
        $id = (int)$matches[1];
        $command->detail($id);
    } elseif (preg_match('/^create\s+([^,]+),\s*([^,]+),\s*(.+)$/', $line, $matches)) {
        $name = $matches[1];
        $email = $matches[2];
        $phoneNumber = $matches[3];
        $command->create($name, $email, $phoneNumber);
    } else {
        echo "Commande inconnue ou incomplète\n";
    }
}
