<?php
class Livre
{
    public static function all(): array
    {
        $st = Database::getInstance()->prepare('SELECT * FROM livres ORDER BY titre');
        $st->execute();
        return $st->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $st = Database::getInstance()->prepare('SELECT * FROM livres WHERE id = :id');
        $st->execute(['id' => $id]);
        return $st->fetch() ?: null;
    }

    public static function count(): int
    {
        $st = Database::getInstance()->prepare('SELECT COUNT(*) FROM livres');
        $st->execute();
        return (int) $st->fetchColumn();
    }

    public static function create(array $d): int
    {
        $pdo = Database::getInstance();
        $st = $pdo->prepare(
            'INSERT INTO livres (titre, auteur, categorie, annee, nb_exemplaires)
             VALUES (:titre, :auteur, :categorie, :annee, :nb)'
        );
        $st->execute(self::params($d));
        return (int) $pdo->lastInsertId();
    }

    public static function update(int $id, array $d): void
    {
        $st = Database::getInstance()->prepare(
            'UPDATE livres
             SET titre = :titre, auteur = :auteur, categorie = :categorie, annee = :annee, nb_exemplaires = :nb
             WHERE id = :id'
        );
        $st->execute(self::params($d) + ['id' => $id]);
    }

    public static function delete(int $id): void
    {
        $st = Database::getInstance()->prepare('DELETE FROM livres WHERE id = :id');
        $st->execute(['id' => $id]);
    }

    private static function params(array $d): array
    {
        return [
            'titre'     => $d['titre'],
            'auteur'    => $d['auteur'],
            'categorie' => $d['categorie'],
            'annee'     => (int) $d['annee'],
            'nb'        => (int) $d['nb_exemplaires'],
        ];
    }
}
