#Robobrol

##Installation

Créer un dépot git en local afin de cloner ce projet.

```
git clone https://github.com/simonclement08/robobrol.git
```

Ajout d'une remote afin de relier votre projet local au projet distant.

```
git remote add origin https://github.com/simonclement08/robobrol.git
```

##Configuration de la base de données

Changer les informations (identifiant, mot de passe et base de données) dans le fichier .env.local

##Création de la base de données, exécution des migrations et chargement des fixtures

Lancer le script composer db afin de :
1. Supprimer la base de données si elle existe
2. Créer la base de données
3. Exécuter les migrations
4. Charger les  fixtures

```
composer db
```

##Lancement serveur de développement

Maintenant que tout est pret, lancer le projet
```
symfony server:start
```
Puis accéder au projet à l'adresse http://127.0.0.1:8000
