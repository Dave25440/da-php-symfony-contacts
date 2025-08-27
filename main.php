<?php

    while (true) {
        $line = readline("Entrez votre commande : ");
        echo "Vous avez saisi : $line\n";

        switch ($line) {
            case "list":
                echo "Affichage de la liste\n";
        }
    }
