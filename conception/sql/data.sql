INSERT INTO compte (identifiant, mot_de_passe, derniere_connexion)
VALUES ('john.pro@mail.com', '$2y$10$tYf7/8AywzrOtFuI/IdrmuTf74wC4Sa2IpK9Qz2yRKobJkDXLdRaS', NULL);
INSERT INTO compte (identifiant, mot_de_passe, derniere_connexion)
VALUES ('test.pro@mail.com', '$2y$10$E999p2k8BlFPQ2se/iX8he8zKT4m.nJ3pQaVl4CnGQ.1Qs0/C0lE.', NULL);
INSERT INTO compte (identifiant, mot_de_passe, derniere_connexion)
VALUES ('testa.pro@mail.com', '$2y$10$jBkDCbQMehT8TD/1Y/72burb15tnJ.1i7lDAJbAizPKB9XeHbtnK.', NULL);
RETURNING id;
INSERT INTO utilisateur (nom, prenom, mail_perso, mail_pro, telephone, compte_id)
VALUES ('Doe', 'John', 'john.perso@mail.com', 'john.pro@mail.com', '0341234567', 1);

INSERT INTO utilisateur (nom, prenom, mail_perso, mail_pro, telephone, compte_id)
VALUES ('Andria', 'Ando', 'test.perso@mail.com', 'test.pro@mail.com', '0341234567', 3);
INSERT INTO utilisateur (nom, prenom, mail_perso, mail_pro, telephone, compte_id)
VALUES ('Rasoa', 'Nirina', 'testa.perso@mail.com', 'testa.pro@mail.com', '0341234567', 2);
RETURNING id;

-- Insertion des Bureaux
INSERT INTO bureau (nom) VALUES
('Paramed SMUR'),
('Med SMUR'),
('SAMU'),
('Cadre');

-- Insertion des Fonctions
INSERT INTO fonction (nom) VALUES
('Amb SMUR'),
('Inf SMUR'),
('Med SMUR'),
('Stg SMUR'),
('SAMU');

-- Insertion des Métiers
INSERT INTO metier (nom) VALUES
('ADE'),
('IDE'),
('IADE'),
('IPDE'),
('Cadre'),
('ARM'),
('Medecin'),
('Interne'),
('Externe'),
('DJ'),
('Etudiant paramedical');

-- Exemple d'utilisateur
INSERT INTO utilisateur (nom, prenom, mail_perso, mail_pro, telephone, compte_id)
VALUES ('Dupont', 'Jean', 'jean.dupont@gmail.com', 'jean.dupont@smur.fr', '0612345678', 1);

-- Exemple de liaison utilisateur <-> fonctions
INSERT INTO utilisateur_fonction (utilisateur_id, fonction_id) VALUES
(1, 1),
(1, 3);

-- Exemple de liaison utilisateur <-> métiers
INSERT INTO utilisateur_metier (utilisateur_id, metier_id) VALUES
(1, 2),
(1, 7);

-- Exemple de liaison utilisateur <-> bureaux
INSERT INTO utilisateur_bureau (utilisateur_id, bureau_id) VALUES
(1, 1),
(1, 3);
