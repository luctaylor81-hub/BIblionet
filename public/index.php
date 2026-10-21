<?php
declare(strict_types=1);

// ===== Front controller : point d'entrée unique de l'application =====
session_start();

define('ROOT', dirname(__DIR__));
define('APP', ROOT . '/app');

$config = require ROOT . '/config/config.php';

// Affichage des erreurs : actif en développement, masqué en production
if ($config['env'] === 'production') {
    ini_set('display_errors', '0');
} else {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
}

// Chemin de base (fonctionne en sous-dossier XAMPP comme à la racine d'un hébergement)
$base = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
define('BASE_URL', $base);

// Autoload simple : core, controllers, models
spl_autoload_register(function (string $class): void {
    foreach (['core', 'controllers', 'models'] as $dir) {
        $file = APP . "/$dir/$class.php";
        if (is_file($file)) {
            require $file;
            return;
        }
    }
});

require APP . '/core/helpers.php';

(new Router())->dispatch($_GET['url'] ?? '');
