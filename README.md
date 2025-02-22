# Test Technique Poker

## Description

Projet de Poker pour un test technique, développée avec Symfony 
qui permet aux utilisateur de comparé sa main avec une main par défaut défini par le test

## Prérequis

Avant de commencer, assurez-vous d'avoir les éléments suivants installés sur votre machine :

- [PHP](https://www.php.net/downloads) (version 8.1 ou supérieure)
- [Composer](https://getcomposer.org/download/)
- [Symfony CLI](https://symfony.com/download)

## Installation
1. Clonez le dépôt :
   ```bash
   git clone https://github.com/votre-nom-utilisateur/poker.git

2. Accédez au répertoire du projet :
   ```bash
   cd poker

3. Installez les dépendances avec Composer :
   ```bash
   composer install

4. Lancer l'application :
   ```bash
   symfony server:start

L'application sera accessible à l'adresse ``http://localhost:8000``

## Utilisation
Remplissez les champs en commençant par une valeur : `2`, `3`, `4`, `5`, `6`, `7`, `8`, `9`, `T`(en), `J`(ack), `Q`(ueen), `K`(ing), `A`(ce)

et une couleur : `S`(pades), `H`(earts), `D`(iamonds), `C`(lubs)

Exemple : [KS] [2H] [5C] [JD] [TD]
