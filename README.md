# FleetManager - Projet Symfony (Docker)

##  Description
FleetManager est une application web de gestion de parc automobile permettant de gérer les véhicules, les chauffeurs et les opérations associées.

## Prérequis

* Docker
* Docker Compose
* Git

## Installation du projet

1. Créer le dossier de travail :

```bash
mkdir FleetManager
cd FleetManager
```

2. Ajouter le socle Docker  dans ce dossier :

- le dossier docker
- le fichier docker-compose.yml

3. Adapter le docker-compose.yml

- Renommer les conteneurs

Dans docker-compose.yaml, renommer les conteneurs en remplaçant symfony par fleetManager.

- Définition des identifiants de connexion  (user, pwd)
- Définir le nom de la base de données (mysql_database)

4. Initialiser Git :

```bash
git init
```

5. Initialisation de GitHub

- Création  d'un repo sur GitHub
- Lier le projet local :


```bash
git remote add origin https://github.com/Theoabogo/FleetManager.git
git add .
git commit -m "Initial commit"
git push -u origin main
```

6. Builder et lancer les conteneurs :

```bash
docker compose up -d --build
```
Avant de builder supprimer tous les conteneurs en une seule commande :
```bash
docker rm -f $(docker ps -qa)
```
“⚠️ Attention : cette commande supprime tous les conteneurs Docker.”


## Conteneurs utilisés

* fleetManager_nginx
* fleetManager_php
* fleetManager_phpmyadmin
* fleetManager_mysql


7. Installer Symfony dans le conteneur PHP :

```bash
docker exec -it fleetManager_php sh
composer create-project symfony/skeleton .
```

## Configuration

Création du fichier `.env.local` puis ajout de:

```
DATABASE_URL="mysql://user:pwd@mysql:3306/fleetManager?serverVersion=8.0.32&charset=utf8mb4"

```
## Lancer le projet

* Application : http://localhost:8080
* PhpMyAdmin : http://localhost:8081


## Commandes utiles

Accéder au conteneur PHP :

```bash
docker exec -it fleetManager_php sh
```

Arrêter les conteneurs :

```bash
docker compose down
```



