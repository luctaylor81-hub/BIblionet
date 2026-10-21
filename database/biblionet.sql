CREATE DATABASE IF NOT EXISTS biblionet CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE biblionet;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS emprunts;
DROP TABLE IF EXISTS adherents;
DROP TABLE IF EXISTS livres;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE users (
    id        INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nom       VARCHAR(100) NOT NULL,
    email     VARCHAR(150) NOT NULL UNIQUE,
    password  VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE livres (
    id              INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    titre           VARCHAR(200) NOT NULL,
    auteur          VARCHAR(150) NOT NULL,
    categorie       VARCHAR(100) NOT NULL,
    annee           SMALLINT UNSIGNED NOT NULL,
    nb_exemplaires  INT UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE adherents (
    id         INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nom        VARCHAR(100) NOT NULL,
    prenom     VARCHAR(100) NOT NULL,
    classe     VARCHAR(50)  NOT NULL,
    telephone  VARCHAR(20)  NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE emprunts (
    id             INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    livre_id       INT UNSIGNED NOT NULL,
    adherent_id    INT UNSIGNED NOT NULL,
    date_emprunt   DATE NOT NULL,
    date_retour    DATE NULL,
    CONSTRAINT fk_emprunts_livre    FOREIGN KEY (livre_id)    REFERENCES livres(id),
    CONSTRAINT fk_emprunts_adherent FOREIGN KEY (adherent_id) REFERENCES adherents(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------- Compte de démonstration ----------
-- Email : admin@biblionet.local  |  Mot de passe : admin123
INSERT INTO users (nom, email, password) VALUES
('Bibliothécaire', 'admin@biblionet.local', '$2y$10$nWHPcHjoVpIv3K.WksaUGu3Cql7WkIpinkxGm7FEYt9BD6iJewAPO');

-- ---------- 16 livres ----------
INSERT INTO livres (titre, auteur, categorie, annee, nb_exemplaires) VALUES
('Le Petit Prince', 'Antoine de Saint-Exupéry', 'Roman', 1943, 3),
('L''Étranger', 'Albert Camus', 'Roman', 1942, 2),
('Les Misérables', 'Victor Hugo', 'Roman', 1862, 2),
('Le Rouge et le Noir', 'Stendhal', 'Roman', 1830, 1),
('Germinal', 'Émile Zola', 'Roman', 1885, 2),
('Une si longue lettre', 'Mariama Bâ', 'Roman', 1979, 3),
('L''Enfant noir', 'Camara Laye', 'Roman', 1953, 2),
('Le monde s''effondre', 'Chinua Achebe', 'Roman', 1958, 2),
('Antigone', 'Jean Anouilh', 'Théâtre', 1944, 2),
('Le Malade imaginaire', 'Molière', 'Théâtre', 1673, 2),
('Fables', 'Jean de La Fontaine', 'Poésie', 1668, 4),
('Les Fleurs du mal', 'Charles Baudelaire', 'Poésie', 1857, 1),
('Introduction à l''algorithmique', 'Thomas H. Cormen', 'Informatique', 1990, 2),
('Clean Code', 'Robert C. Martin', 'Informatique', 2008, 2),
('Sapiens : une brève histoire de l''humanité', 'Yuval Noah Harari', 'Histoire', 2011, 3),
('Nations nègres et culture', 'Cheikh Anta Diop', 'Histoire', 1954, 1);

-- ---------- 12 adhérents ----------
INSERT INTO adherents (nom, prenom, classe, telephone) VALUES
('Ondo', 'Prisca', '3eA', '077 00 00 01'),
('Mintsa', 'Luc', '3eA', '077 00 00 02'),
('Essono', 'Clarisse', '3eB', '077 00 00 03'),
('Ekomi', 'Brice', '2ndeA', '077 00 00 04'),
('Bivigou', 'Estelle', '2ndeA', '077 00 00 05'),
('Ngoua', 'Daniel', '2ndeB', '077 00 00 06'),
('Mavoungou', 'Ruth', '1ereC', '077 00 00 07'),
('Mba', 'Steeve', '1ereC', '077 00 00 08'),
('Nzamba', 'Aline', '1ereD', '077 00 00 09'),
('Oyane', 'Hugues', 'TleC', '077 00 00 10'),
('Koumba', 'Nadège', 'TleD', '077 00 00 11'),
('Moukagni', 'Rodrigue', 'TleD', NULL);

-- ---------- Quelques emprunts de test (utiles pour le J3) ----------
INSERT INTO emprunts (livre_id, adherent_id, date_emprunt, date_retour) VALUES
(1,  1, '2026-10-12', NULL),
(6,  2, '2026-10-14', NULL),
(14, 3, '2026-10-05', '2026-10-12'),
(4,  4, '2026-10-15', NULL);
