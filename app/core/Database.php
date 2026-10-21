<?php
// Connexion PDO unique (singleton). Aucune requête SQL ici : uniquement la connexion.
class Database
{
    private static ?PDO $pdo = null;

    public static function getInstance(): PDO
    {
        if (self::$pdo === null) {
            $config = require ROOT . '/config/config.php';
            $db = $config['db'];
            $dsn = "mysql:host={$db['host']};dbname={$db['name']};charset=utf8mb4";

            try {
                self::$pdo = new PDO($dsn, $db['user'], $db['pass'], [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
            } catch (PDOException $e) {
                http_response_code(500);
                if ($config['env'] === 'production') {
                    exit('Erreur de connexion à la base de données.');
                }
                exit('Erreur de connexion à la base de données : ' . htmlspecialchars($e->getMessage()));
            }
        }
        return self::$pdo;
    }
}
