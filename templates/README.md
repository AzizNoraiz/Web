# Casino Royal - Plateforme de Jeux en Ligne

## Membres du groupe
- AZIZ Noraiz noraizaziz72@gmail.com
- LE CHAIX Thomas thomas.lechaix14@gmail.com
- BARTHE Arthur arthur.barthe04@gmail.com
- D'ABADIE DE LURBE Andy andy.dabadie@gmail.com

## Description du projet
Casino Royal est une application web de casino virtuel permettant aux utilisateurs de jouer à différents jeux de hasard (777, Bingo, Quitte ou Double) après s'être authentifiés. Le projet intègre un système de gestion de jetons, un historique des gains et un chatbot intelligent pour accompagner les joueurs.

### Technologies utilisées
- Framework Backend : Symfony (PHP 8.2+)
- Moteur de template : Twig
- ORM : Doctrine
- Base de données : MySQL
- Framework CSS : Bootstrap 5
- Intelligence Artificielle : Microservice en Python (RAG)
- Conteneurisation : Docker
- Dynamisme Front-End JavaScript
- Gestionnaire de Dépendances : Composer pour PHP et Pip pour Python

## Installation et lancement avec Docker

```bash
# Cloner le projet
git clone https://github.com/AzizNoraiz/Web.git
cd projet

# Lancer les conteneurs Docker
docker-compose up -d

# Installer les dépendances
docker exec -it casino_php composer install

# Créer la base de données
docker exec -it casino_php php bin/console doctrine:database:create

# Lancer les migrations pour créer les tables
docker exec -it casino_php php bin/console doctrine:migrations:migrate

#Charger les données de test (Fichier SQL)
Fichier casino_db.sql

## Configuration et Lancement du ChatBot

Le ChatBot fonctionne via un microservice Python indépendant.

### Lancement du microservice
Ouvrez un nouveau terminal, placez-vous dans le dossier du script Python et exécutez les commandes suivantes :

# Installer les dépendances Python nécessaires
pip3 install -r requirements.txt

# Lancer le ChatBot
python3 serveurBot.py