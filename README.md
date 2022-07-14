# KGB - Evaluatio Studi
Kgb est un site internet permettant :
- Aux visiteurs de consulter la liste complete des missions
- Aux Administrateurs, de créer, editer ou supprimer tous les éléments des missions

## Environnement de développement
###Pré-requis
* Php 8.0.2
* Symfony CLI

Vous pouvez vérifier les prérequis en utilisant la commande (CLI de symfony)

```bash
    symfony check:requirements
```
## Environement de Base de données
Pour le develloppement, utilisation de MariaDB en local

Creation de la base de données

```symfony console doctrine:database:create```



## Installation de Bootstrap
installation de Webpack Encore

``composer require symfony/webpack-encore-bundle``

ensuite on charge npm avec

``npm install ``

On change:
- assets/styles/<strong>app.css</strong> <br>
  en
- assets/styles/<strong>app.scss</strong>

Dans le fichier assets/app.js on modifie la ligne
``
import './styles/app.scss';
``

Dans le fichier webpack.config.js, on décommente :
- .enableSassLoader()

Installation de Sass Loader et Sass

``npm install sass-loader node-sass --save-dev``

Installation de Postcss et autoprefixer

``npm instal postcss-loader autoprefixer --dev``

On crée un fichier postcss.config.js dans lequel on ajoute :

````
module.exports = {
plugins: {
       // include whatever plugins you want
       // add browserslist config to package.json (see below)
        autoprefixer: {}
    }
}
````

Installation de Bootstrap :

``npm install bootstrap``

Dans assets/styles on crée un fichier custom.scss
et dans le fichier assets/styles/app.scss on ajoute :

````
@import "custom";
@import "~bootstrap/scss/bootstrap";
````
## Ajout de Fontawesome

```npm install --save-dev @fortawesome/fontawesome-free```

Aprés installation, require font-awesome dans le fichier de config `: assets/js/app.js

``````
require('@fortawesome/fontawesome-free/css/all.min.css'); 
require('@fortawesome/fontawesome-free/js/all.js');
``````
## Installation du bundle Paginator
Lancer la commande pour installer : 
````
composer require knplabs/knp-paginator-bundle
````
Dans le dossier 'config/packages' créer un fichier 'paginator.yaml' et ajouter le code suivant 
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
Dans le Controller qui va utiliser la pagination, on injecte 'PaginatorInterface', et pour appeller la pagination :
````
 $data = $missionRepository->findAll();

        $mission = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1 ), //indique le numero de page par defaut
            4 //indique le nombre d'objet à afficher
        );
````

Dans la view du controller, ajouter : 
````
{# display navigation #}
<div class="navigation">
    {{ knp_pagination_render(pagination) }}
</div>
````

## Installation des Datafixture et FakerPhp

``composer require --dev orm-fixtures``

``composer require fakerphp/faker``

Pour charger les fixtures  :

``symfony console doctrine:fixtures:load ou d:f:l``

## Installation de Paginator

Integration du bundle KNP Paginator avec la commande Composer :

````composer require knplabs/knp-paginator-bundle````

Dans le Controller on injecte Paginator, Request et le repository necessaire
``````
use App\Repository\MissionRepository;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
``````

````````
public function index(
        MissionRepository $missionRepository,
        PaginatorInterface $paginator, // Inject Knp Paginator bundle
        Request $request // Request needed to get the page number
        ): Response
    {
        $data = $missionRepository->findAll(); //Request with data 
        
        $missions = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1), // URL page number
            4 // Result per page
        );

        return $this->render('home/index.html.twig', [
            'missions' => $missions
        ]);
    }
````````
Dans le template Twig on ajoute :

````
{{ knp_pagination_render(missions, 'partials/_pagination.html.twig'//<--template pour l'affichage ) }}
````

## Install Twig String Extra

Permet d'utiliser le String Component de Symfony

````
composer require twig/string-extra
````

### Deployer le site en production sur Heroku :

Creation du dossier projet sur heroku

```
heroku create <nom du projet>
```

Ajout du fichier Procfile à la racine du projet et ajouter le path public ( chemin d'acces)

````
web: heroku-php-apache2 public/
````

Configurer la variable d'environnement en mode production avec la commande

````
heroku config:set APP_ENV=prod
````









