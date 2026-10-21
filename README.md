# BiblioNet - Gestion d'une bibliothèque (PHP / MySQL, MVC)

Mini-projet en architecture MVC **sans framework** : front controller, routeur simple,
PDO avec requêtes préparées, authentification par session.

## État d'avancement

| Jour | Contenu | État |
|------|---------|------|
| J1 | Socle MVC (Router, Database, Controller, layout), base + données de test, page d'accueil | Fait |
| J2 | Authentification, CRUD livres, CRUD adhérents | Fait |
| J3 | Catalogue public + recherche, emprunts/retours, mise en ligne | À faire |
| J4 | Finalisation, rapport, soutenance | À faire |

## Installation locale (XAMPP / Windows)

1. Copier le dossier `biblionet` dans `C:\xampp\htdocs\`.
2. Démarrer **Apache** et **MySQL** depuis le panneau XAMPP.
3. Ouvrir phpMyAdmin (`http://localhost/phpmyadmin`), onglet **Importer**, choisir `database/biblionet.sql`.
4. Copier `.env.example` en `.env` (valeurs XAMPP par défaut : utilisateur `root`, mot de passe vide).
5. Ouvrir `http://localhost/biblionet/public/`.

**Compte de démonstration :** `admin@biblionet.local` / `admin123`

## Arborescence

```
biblionet/
├── app/
│   ├── controllers/   Home, Auth, Livre, Adherent
│   ├── models/        User, Livre, Adherent
│   ├── views/         layouts/, home/, auth/, livres/, adherents/, errors/
│   └── core/          Router, Controller, Database, helpers
├── config/config.php  (lit le fichier .env)
├── public/            SEUL dossier exposé : index.php, .htaccess, assets/
├── database/biblionet.sql
├── docs/              MCD/MLD et maquettes (J1)
├── .env.example
└── .gitignore         (exclut .env)
```

## Routes disponibles

| URL | Action |
|-----|--------|
| `/` | Accueil |
| `/auth/login`, `/auth/logout` | Connexion / déconnexion |
| `/livres`, `/livres/create`, `/livres/edit/5` | Liste, ajout, modification |
| `/adherents`, `/adherents/create`, `/adherents/edit/5` | Liste, ajout, modification |

Les actions `store`, `update` et `delete` sont en POST et protégées par un jeton CSRF.

## Règles respectées

- Aucune requête SQL dans les vues, aucun HTML dans les modèles.
- Toutes les requêtes passent par PDO avec des requêtes préparées.
- Toute donnée affichée est échappée avec `htmlspecialchars` (fonction `e()`).
- Mots de passe hachés avec `password_hash` / `password_verify`.
- Pages de gestion protégées par la session.

## Générer un nouveau hash de mot de passe

```php
<?php echo password_hash('nouveau_mot_de_passe', PASSWORD_DEFAULT);
```
