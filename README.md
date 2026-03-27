Voici la version en **texte simple (propre, naturel, prêt à copier-coller)** 👇

---

# ExamenLaravel — API REST Gestion Étudiants & Cours

API REST développée avec Laravel 12 pour gérer des étudiants, des cours et leurs inscriptions.
Projet réalisé dans le cadre de la Licence STI à l’IPD.

---

## Présentation

Ce projet est une API REST (sans interface graphique) qui permet de gérer :

* les étudiants (ajout, modification, suppression, affichage)
* les cours (ajout, modification, suppression, affichage)
* les inscriptions des étudiants aux cours (relation many-to-many)

Toutes les réponses sont en JSON.
Les routes sont accessibles via /api/v1 et sécurisées avec un système de token.

---

## Technologies utilisées

* PHP 8.2
* Laravel 12
* Laravel Sanctum (authentification)
* MySQL
* PHPUnit (tests)

---

## Prérequis

Avant de lancer le projet, il faut avoir installé :

* PHP 8.2 ou plus
* Composer
* MySQL
* Node.js (optionnel)
* Git

---

## Installation

1. Cloner le projet

git clone [https://github.com/Minela1234/ExamenLaravel.git](https://github.com/Minela1234/ExamenLaravel.git)
cd ExamenLaravel

2. Installer les dépendances

composer install

3. Configurer l’environnement

cp .env.example .env

Modifier les informations de la base de données dans .env :

DB_DATABASE=examenlaravel
DB_USERNAME=root
DB_PASSWORD=

Créer la base de données si nécessaire :

CREATE DATABASE examenlaravel;

4. Générer la clé

php artisan key:generate

5. Installer Sanctum

php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"

6. Lancer les migrations

php artisan migrate

7. (Optionnel) Ajouter des données

php artisan db:seed

---

## Lancer le projet

php artisan serve

Accès à l’API :
[http://127.0.0.1:8000/api/v1](http://127.0.0.1:8000/api/v1)

---

## Base de données

Le projet contient 3 tables principales :

* etudiants
* cours
* cours_etudiant (table pivot)

Un étudiant peut suivre plusieurs cours, et un cours peut avoir plusieurs étudiants.

---

## Authentification

L’API utilise un système de token.

Routes principales :

POST /auth/register → créer un compte
POST /auth/login → se connecter
POST /auth/logout → se déconnecter
GET /auth/me → infos utilisateur

Pour accéder aux routes protégées :

Authorization: Bearer {token}

---

## Endpoints principaux

Étudiants :

GET /etudiants
POST /etudiants
GET /etudiants/{id}
PUT /etudiants/{id}
DELETE /etudiants/{id}

Cours :

GET /cours
POST /cours
GET /cours/{id}
PUT /cours/{id}
DELETE /cours/{id}

Inscriptions :

POST /etudiants/{id}/cours/attach
POST /etudiants/{id}/cours/detach
POST /etudiants/{id}/cours/sync

---

## Exemple

Créer un étudiant :

POST /api/v1/etudiants
Authorization: Bearer {token}

{
"prenom": "Lamine",
"nom": "Diallo",
"email": "[lamine.diallo@example.com](mailto:lamine.diallo@example.com)",
"date_naissance": "2002-05-15"
}

---

## Sécurité

* Authentification avec token
* Limitation des requêtes
* Validation des données

---

## Tests

Pour lancer les tests :

php artisan test

---

## Structure du projet

* Controllers → logique de l’API
* Models → gestion des données
* Requests → validation
* Resources → format des réponses
* Tests → tests automatisés

---

## Auteur

Projet réalisé dans le cadre du cours de développement API REST (Licence STI - IPD).
