# Projet bibliothèque - ECF

Cette appli permet de gérer une bibliothéque.

## Install

    git clone https://github.com/Cltglt/ECF-Backend
    cd ECF-Backend
    composer install

Après install du projet, créez le fichier `.env.local` et ajoutez-y les variables `APP_ENV` et `DATABASE_URL`.

Créez la BDD avec PhpMyAdmin.

Ensuite créez le schéma de la BDD et injectez les données de test avec la commande :

    bin/dofilo.sh

## Utilisation

    symfony serve

Ensuite visitez la page [http://localhost:8000](http://localhost:8000).

## Structure de la BDD, données indispensables et données de test

### User

Attributs :

- id : clé primaire
- email : varchar 190
- roles : text
- password : varchar 190

Relations :

- aucune

Données indispensables :

| id | email               | roles              | password                                                     |
|----|---------------------|--------------------|--------------------------------------------------------------|
| 1  | admin@example.com   | ["ROLE_ADMIN"]     | $2y$10$/H2ChUxriH.0Q33g3EUEx.S2s4j/rGJH2G88jK9nCP60GbUW8mi5K |
| 2  | foo.foo@example.com | ["ROLE_EMRUNTEUR"] | $2y$10$/H2ChUxriH.0Q33g3EUEx.S2s4j/rGJH2G88jK9nCP60GbUW8mi5K |
| 3  | bar.bar@example.com | ["ROLE_EMRUNTEUR"] | $2y$10$/H2ChUxriH.0Q33g3EUEx.S2s4j/rGJH2G88jK9nCP60GbUW8mi5K |
| 4  | baz.baz@example.com | ["ROLE_EMRUNTEUR"] | $2y$10$/H2ChUxriH.0Q33g3EUEx.S2s4j/rGJH2G88jK9nCP60GbUW8mi5K |

Note : le mot de passe haché correspond au mot de passe clair `123`.

Données de test : 100 users dont les données sont générées aléatoirement

Attention : chaque user doit être relié à un emprunteur mais n'oubliez pas que la relation est unidirectionnelle et qu'elle n'est visible que depuis l'emprunteur


### Livre

Attributs :

- id : clé primaire
- titre : varchar 190
- annee_edition : int, nullable
- nombre_pages : int
- code_isbn : varchar 190, nullable

Relations :

- auteur : many to one
- genres : many to many
- emprunts : one to many

Données indispensables :

| id | titre                       | annee_edition | nombre_pages | code_isbn     | auteur_id |
|----|-----------------------------|---------------|--------------|---------------|-----------|
| 1  | 	  | 2010          | 100          | 9785786930024 | 1         |
| 2  | Consectetur adipiscing elit | 2011          | 150          | 9783817260935 | 2         |
| 3  | Mihi quidem Antiochum       | 2012          | 200          | 9782020493727 | 3         |
| 4  | Quem audis satis belle      | 2013          | 250          | 9794059561353 | 4         |

| livre_id | genre_id |
|----------|----------|
| 1        | 1        |
| 2        | 2        |
| 3        | 3        |
| 4        | 4        |

Données de test : 1000 livres dont les données sont générées aléatoirement.
N'oubliez pas créer également les relations.

### Auteur

Attributs :

- id : clé primaire
- nom : varchar 190
- prenom : varchar 190

Relations :

- livres : one to many

Données indispensables :

| id | nom            | prenom |
|----|----------------|--------|
| 1  | auteur inconnu |        |
| 2  | Cartier        | Hugues |
| 3  | Lambert        | Armand |
| 4  | Moitessier     | Thomas |

Données de test : 500 auteurs dont les données sont générées aléatoirement

### Genre

Attributs :

- id : clé primaire
- nom : varchar 190
- description : text, nullable

Relations :

- livres : many to many

Données indispensables :

| id | nom              | description |
|----|------------------|-------------|
| 1  | poésie           | NULL        |
| 2  | nouvelle         | NULL        |
| 3  | roman historique | NULL        |
| 4  | roman d'amour    | NULL        |
| 5  | roman d'aventure | NULL        |
| 6  | science-fiction  | NULL        |
| 7  | fantasy          | NULL        |
| 8  | biographie       | NULL        |
| 9  | conte            | NULL        |
| 10 | témoignage       | NULL        |
| 11 | théâtre          | NULL        |
| 12 | essai            | NULL        |
| 13 | journal intime   | NULL        |

Données de test : aucunes


### Emprunteur

Attributs :

- id : clé primaire
- nom : varchar 190
- prenom : varchar 190
- tel : varchar 190
- actif : boolean
- date_creation : datetime
- date_modification : datetime, nullable

Relations :

- emprunts : one to many
- user : one to one, unidirectionnel

Données indispensables :

| id | nom | prenom | tel       | actif | date_creation     | date_modification | user_id |
|----|-----|--------|-----------|-------|-------------------|-------------------|---------|
| 1  | foo | foo    | 123456789 | true  | 20200101 10:00:00 | NULL              | 2       |
| 2  | bar | bar    | 123456789 | false | 20200201 11:00:00 | 20200501 12:00:00 | 3       |
| 3  | baz | baz    | 123456789 | true  | 20200301 12:00:00 | NULL              | 4       |

Données de test : 100 emprunteurs dont les données sont générées aléatoirement

Attention : chaque emprunteur doit être relié à un compte user

### Emprunt

Attributs :

- id : clé primaire
- date_emprunt : datetime
- date_retour : datetime, nullable

Relations :

- emprunteur : many to one
- livre : many to one	

Données indispensables :

| id | date_emprunt        | date_retour         | emprunteur_id | livre_id |
|----|---------------------|---------------------|---------------|----------|
| 1  | 2020-02-01 10:00:00 | 2020-03-01 10:00:00 | 1             | 1        |
| 2  | 2020-03-01 10:00:00 | 2020-04-01 10:00:00 | 2             | 2        |
| 3  | 2020-04-01 10:00:00 | NULL                | 3             | 3        |

Données de test : 200 emprunts dont les données sont générées aléatoirement

<!-- 
## Arbre de dépendance des entités

- Client
  - User
- Project
- SchoolYear
- Student
  - SchoolYear
  - User
- Tag
- Teacher
  - User
- User -->