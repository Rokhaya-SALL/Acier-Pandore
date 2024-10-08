# Acier-Pandore

## Description

L'application __Acier-Pandore__ propose une plateforme de gestion de produits, permettant aux utilisateurs de :

* Se connecter.
* Rechercher des produits via un moteur de recherche.
* Filtrer les produits par catégories.
* Afficher la liste complète des produits.
* Voir les détails d'un produit spécifique.

Des fonctionnalités avancées permettent aux administrateurs de gérer les produits via une interface EasyAdmin, avec la possibilité d'ajouter, modifier et gérer des images associées aux produits.

## Fonctionnalités

### Moteur de recherche
L'application inclut un moteur de recherche permettant de trouver des produits spécifiques par le nom.

### Upload d'images
Le système permet aux administrateurs d'uploader des images pour les produits et de les afficher dynamiquement dans les vues. Les images uploadées via l'interface EasyAdmin s'affichent correctement dans les pages de produits.

### Interface d'administration
L'interface EasyAdmin permet aux administrateurs de :

* Ajouter des produits via une page dédiée.
* Modifier des produits via une autre page, uniquement accessible aux administrateurs.

Code de la barre de navigation pour les administrateurs :
```
{% if is_granted('ROLE_ADMIN') %}
    <a class="dropdown-item" href="{{ path('product_add') }}">Ajouter un produit</a>
    <a class="dropdown-item" href="{{ path('product_update') }}">Modifier un produit</a>
{% endif %}
```
## Problèmes rencontrés

1. __Affichage de la page d'administration après la connexion__
Un problème a été rencontré lors de l'affichage de la page d'administration après connexion, un lien a finalement été ajouté dans la navbar pour accéder à l'interface EasyAdmin lorsqu'on se connecte comme admin.
```
{% if is_granted('IS_AUTHENTICATED_FULLY') %}
    {% if is_granted('ROLE_ADMIN') %}
        <li class="nav-item">
            <a class="nav-link text-black" href="{{ path('admin') }}">Admin</a>
        </li>
    {% else %}
        <li class="nav-item">
            <a class="nav-link text-black" href="{{ path('app_profile') }}">Mon compte</a>
        </li>
{% endif %}
```
2. __Problème d'affichage des images dans EasyAdmin__
Bien que les images intégrées manuellement via __AppFixture__ s'affichent correctement, un problème a été constaté avec les images uploadées via l'interface EasyAdmin. Seules les images manuellement intégrées apparaissent.

Pour tenter de résoudre ce problème, le dossier __images__ a été déplacé de __assets__ vers __public__. L'idée est de gérer les images selon leur emplacement, comme illustré par le code ci-dessous :

```
$product = $this->getContext()->getEntity()->getInstance();

if ($product && $product->getImage()) {
    $imagePath = $product->getImage();

    if (strpos($imagePath, 'images/') === 0) {
        // Si l'image est dans le répertoire public/images
        $imageField->setBasePath('/images');
    } else {
        // Sinon, l'image est dans uploads/images
        $imageField->setBasePath('/uploads/images');
    }
}
```
L'installation de vich_uploader est aussi une tentative pour résoudre ce problème

3. __Résolution de l'affichage des images dans les vues des produits__
Le problème d'affichage des images dans les vues a été résolu grâce à la condition suivante dans le template :
```
{% if product.image %}
    <div class="mb-4 text-center">
        {% if product.image starts with 'images/' %}
            <img src="{{ asset(product.image) }}" alt="{{ product.name }}" class="img-fluid rounded mb-3">
        {% else %}
            <img src="{{ asset('uploads/images/' ~ product.image) }}" alt="{{ product.name }}" class="img-fluid rounded mb-3">
        {% endif %}
    </div>
{% endif %}
```
Ce code gère l'affichage correct des images en vérifiant si l'image est dans le dossier __public/images__ ou __uploads/images__.