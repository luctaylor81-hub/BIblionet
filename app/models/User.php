<?php
class User
{
    public static function findByEmail(string $email): ?array
    {
        $st = Database::getInstance()->prepare('SELECT id, nom, email, password FROM users WHERE email = :email');
        $st->execute(['email' => $email]);
        return $st->fetch() ?: null;
    }
}
