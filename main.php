<?php

spl_autoload_register(static function ($fqcn): void {
    if (str_starts_with($fqcn, 'App\\Config')) {
        $path = sprintf('%s.php', str_replace(['App\\Config', '\\'], ['config', '/'], $fqcn));
    } else {
        $path = sprintf('%s.php', str_replace(['App', '\\'], ['src', '/'], $fqcn));
    }

    require_once $path;
});

$config = require_once __DIR__ . '/config/config.php';

use App\Config\DBConnect;
use App\Command\Command;

$db = new DBConnect(
    $config['db_host'],
    $config['db_name'],
    $config['db_port'],
    $config['db_user'],
    $config['db_password']
);
$pdo = $db->getPDO();

$command = new Command($pdo);

while (true) {
    $line = readline("Entrez votre commande : ");

    if ($line === 'quit') {
        echo "Au revoir\n";
        break;
    }

    elseif ($line === 'help') {
        $command->help();
    }

    elseif ($line === 'list') {
        $command->list();
    }

    // Expression régulière pour vérifier le format de l'entrée : 'detail' + espace(s) + entier (id)
    elseif (preg_match('/^detail\s+(\d+)$/', $line, $matches)) {
        $id = (int)$matches[1];
        $command->detail($id);
    }

    // 'create' + espace(s) + chaîne (nom), chaîne (email), chaîne (téléphone)
    elseif (preg_match('/^create\s+([^,]+),\s*([^,]+),\s*(.+)$/', $line, $matches)) {
        $name = $matches[1];
        $email = $matches[2];
        $phoneNumber = $matches[3];
        $command->create($name, $email, $phoneNumber);
    }

    // 'modify' + espace(s) + entier (id), chaîne (nom), chaîne (email), chaîne (téléphone)
    elseif (preg_match('/^modify\s+(\d+),\s*([^,]+),\s*([^,]+),\s*(.+)$/', $line, $matches)) {
        $id = (int)$matches[1];
        $name = $matches[2];
        $email = $matches[3];
        $phoneNumber = $matches[4];
        $command->modify($id, $name, $email, $phoneNumber);
    }

    // 'delete' + espace(s) + entier (id)
    elseif (preg_match('/^delete\s+(\d+)$/', $line, $matches)) {
        $id = (int)$matches[1];
        $command->delete($id);
    }

    else {
        echo "Commande inconnue ou incomplète\n";
    }
}
