# Exercices de QA - Symfony 6

## Sommaire

 * [A propos](#a-propos)
 * [Installation](#installation)

## A propos

Ceci est un repository pour s'exercer à la QA d'une API simple, écrite en Symfony 6 et php 8. Il permettra de vous entrainer à utiliser PHPUnit pour écrire des tests unitaires et fonctionnels.

## Installation

__Pré-requis :__

 * docker engine
 * docker-compose

Pour initialiser le projet, veuillez faire un fork du repository sur votre compte. Puis, lancer les commandes suivantes :

```bash
git clone https://github.com/<your-username>/qa_exercices

cd qa_exercices

docker-compose up -d --build

docker-compose exec -u 1000 qa-exercices-php bash

composer install
```