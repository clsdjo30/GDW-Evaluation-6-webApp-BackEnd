# KGB - Evaluation BackEnd Studi

## Table des matières

- [Aperçus](#aperus)
  - [Le projet](#le-projet)
  - [Liens](#liens)
  - [Screenshot](#screenshot)
  - [Environement de developpement](#environnement-de-dveloppement)
  - [Environement de base de données](#environement-de-base-de-donnes)
- [Librairies & Bundle](#librairies--bundles)
  - [Installation de Bootstrap](#installation-de-bootstrap)
  - [Ajout de Fontawesome](#ajout-de-fontawesome)
  - [Installation du bundle Paginator](#installation-du-bundle-paginator)
  - [Installation du bundle Twig Extra](#installation-du-bundle-paginator)
  - [Installation des Datafixture et FakerPhp](#installation-des-datafixture-et-fakerphp)
  - [Installation du bundle EAsyadmin](#installation-du-bundle-easyadmin)
- [Déploiement](#deployer-le-site-en-production-sur-heroku)

## Aperçus

### Le projet

Kgb est une application permettant :

- Aux visiteurs de consulter une liste complete des missions ainsi que leur détails
- Aux consultants, de créer, editer ou supprimer tous les éléments des missions

### Liens

Le lien vers le depot [Github](https://github.com/clsdjo30/GDW-Evaluation-6-webApp-BackEnd).  
Une demonstration du projet est disponible - [Korp General Business](https://gdw-kgb-consulting.herokuapp.com/)

### Screenshot

[Mobile View](./overview/mobile-view.png)  
[Desktop View]()

### Environnement de développement

* Php 8.0.2
* Symfony CLI
* NodeJs

Vous pouvez vérifier les prérequis en utilisant la commande (CLI de symfony)

```bash
    symfony check:requirements
```

### Environement de Base de données

Pour le develloppement, utilisation de MariaDB en local

Creation de la base de données

```symfony console doctrine:database:create```

## Librairies & Bundles

### Installation de Bootstrap

1. Installation de Webpack Encore  
   ``composer require symfony/webpack-encore-bundle``

2. On charge NodeJs   
   ``npm install ``

3. On change:

- assets/styles/<strong>app.css</strong> <br>
  en
- assets/styles/<strong>app.scss</strong>

4. Dans le fichier "assets/app.js" on modifie la ligne
   ``
   import './styles/app.scss';
   ``

5. Dans le fichier webpack.config.js, on décommente :  
   ``
   enableSassLoader()
   ``
6. Installation de Sass Loader et Sass  
   ``npm install sass-loader node-sass --save-dev``

7. Installation de Postcss et autoprefixer  
   ``npm instal postcss-loader autoprefixer --dev``

8. On crée un fichier postcss.config.js dans lequel on ajoute :

```
module.exports = {
plugins: {
       // include whatever plugins you want
       // add browserslist config to package.json (see below)
        autoprefixer: {}
    }
}
```

9. Installation de Bootstrap :  
   ``npm install bootstrap``

10. Dans assets/styles on crée un fichier custom.scss
    et dans le fichier assets/styles/app.scss on ajoute :

````
@import "custom";
@import "~bootstrap/scss/bootstrap";
````

### Ajout de Fontawesome

```npm install --save-dev @fortawesome/fontawesome-free```

Aprés installation, require font-awesome dans le fichier de config `: assets/js/app.js

``````
require('@fortawesome/fontawesome-free/css/all.min.css'); 
require('@fortawesome/fontawesome-free/js/all.js');
``````

### Installation du bundle Paginator

1. Pour installer :   
   ``
   composer require knplabs/knp-paginator-bundle
   ``
2. Dans le dossier 'config/packages' créer un fichier 'paginator.yaml' et ajouter le code suivant

````
knp_paginator:
    page_range: 5                       # number of links shown in the pagination menu (e.g: you have 10 pages, a page_range of 3, on the 5th page you'll see links to page 4, 5, 6)
    default_options:
        page_name: page                 # page query parameter name
        sort_field_name: sort           # sort field query parameter name
        sort_direction_name: direction  # sort direction query parameter name
        distinct: true                  # ensure distinct results, useful when ORM queries are using GROUP BY statements
        filter_field_name: filterField  # filter field query parameter name
        filter_value_name: filterValue  # filter value query parameter name
    template:
        pagination: '@KnpPaginator/Pagination/sliding.html.twig'     # sliding pagination controls template
        sortable: '@KnpPaginator/Pagination/sortable_link.html.twig' # sort link template
        filtration: '@KnpPaginator/Pagination/filtration.html.twig'  # filters template
````

3. Dans le Controller qui va utiliser la pagination, on injecte 'PaginatorInterface', et pour appeller la pagination :

````
 $data = $missionRepository->findAll();

        $mission = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1 ), //indique le numero de page par defaut
            4 //indique le nombre d'objet à afficher
        );
````

4. Dans la view du controller, ajouter :

````
{# display navigation #}
<div class="navigation">
    {{ knp_pagination_render(pagination) }}
</div>
````

### Installation du bundle Twig Extra

1. Installer le bundle  
   ``composer require twig/string-extra``
2. Utilisation pour couper un long texte  
   ``{{ mission.description | u.truncate(100, '...', true) }}``

### Installation des Datafixture et FakerPhp

1. Installation du bundle symfony Fixture  
   ``composer require --dev orm-fixtures``
2. Installation du bundle FakerPhp  
   ``composer require fakerphp/faker``
3. Créer les données de test dans le fichier DataFixtures.php
4. Pour charger les fixtures  :  
   ``symfony console doctrine:fixtures:load ou d:f:l``

### Installation du bundle EAsyAdmin

1. Pour installer le bundle EasyAdmin:  
   ``
   composer require easycorp/easyadmin-bundle
   ``
2. Pour créer un panel d'administration:  
   ``
   symfonfony console make:admin:dashboard
   ``
3. Generer un CRUD:  
   ``
   symfony console make:admin:crud
   ``

### Deployer le site en production sur Heroku

1. Creation du dossier projet sur heroku  
   ``
   heroku create <nom du projet>
   ``

2. Création d'un fichier Procfile à la racine du projet
````
## Insérer le code ci dessous ##
release: php bin/console doctrine:migrations:migrate
web: heroku-php-apache2 public/
````

3. Configurer la variable d'environnement en mode production avec la commande  
   ``
   heroku config:set APP_ENV=prod
   ``
4. Ajout de Apache  
   ``
   web: heroku-php-apache2 public/
   ``
5. Dans Heroku, ajouter le addons pour la BDD. J'ai choisi ClearDB Mysql pour son plan gratuit

- Dans le client Heroku, dans l'onglet "Settings/Config Vars", on ajoute une nouvelle Variable pour la BDD  
  ``
  DATABASE_URL="<Renseigner le lien de "CLEARDB_DATABASE_URL">"
  ``
- Dans le fichier .env à la racine du projet on modifie la DATABASE_URL avec le lien vers la BDD créee dans heroku

6. Ajout du buildpacks pour Nodejs  
   ``
   heroku buildpacks:add heroku/nodejs
   ``

- Dans le fichier package.json on ajoute en dessous de "scripts"

````
 "engines": {
        "node": "<numéro de version de node installer sur la machine>",
        "npm": "<numéro de npm installer sur la machine>"
    },
````

7. Deployement du projet sur le depot Heroku  
   ``
   git push heroku main
   ``









