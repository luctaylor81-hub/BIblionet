<?php
class Adherent
{
    public static function all(): array
    {
        $st = Database::getInstance()->prepare('SELECT * FROM adherents ORDER BY nom, prenom');
        $st->execute();
        return $st->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $st = Database::getInstance()->prepare('SELECT * FROM adherents WHERE id = :id');
        $st->execute(['id' => $id]);
        return $st->fetch() ?: null;
    }

    public static function count(): int
    {
        $st = Database::getInstance()->prepare('SELECT COUNT(*) FROM adherents');
        $st->execute();
        return (int) $st->fetchColumn();
    }

    public static function create(array $d): int
    {
        $pdo = Database::getInstance();
        $st = $pdo->prepare(
            'INSERT INTO adherents (nom, prenom, classe, telephone)
             VALUES (:nom, :prenom, :classe, :telephone)'
        );
        $st->execute(self::params($d));
        return (int) $pdo->lastInsertId();
    }

    public static function update(int $id, array $d): void
    {
        $st = Database::getInstance()->prepare(
            'UPDATE adherents SET nom = :nom, prenom = :prenom, classe = :classe, telephone = :telephone
             WHERE id = :id'
        );
        $st->execute(self::params($d) + ['id' => $id]);
    }

    public static function delete(int $id): void
    {
        $st = Database::getInstance()->prepare('DELETE FROM adherents WHERE id = :id');
        $st->execute(['id' => $id]);
    }

    private static function params(array $d): array
    {
        return [
            'nom'       => $d['nom'],
            'prenom'    => $d['prenom'],
            'classe'    => $d['classe'],
            'telephone' => $d['telephone'],
        ];
    }
}
