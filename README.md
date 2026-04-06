# EvEnsa Portal

Plateforme institutionnelle de gestion, validation, planification et valorisation des événements universitaires.

## Objectif

EvEnsa permet de :
- centraliser les demandes d’organisation d’événements
- accompagner le travail de la commission
- publier les événements validés
- valoriser les instances et les annonces sur un portail public

## Modules principaux

- Portail public
- Portail instance
- Administration / commission
- Référentiels
- Demandes d’organisation
- Événements
- Bilans post-événement
- Annonces

## Stack technique

- Laravel 12
- Filament 5
- MySQL
- Vite
- Tailwind CSS
- Spatie Laravel Permission

## Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
npm install
npm run dev
php artisan serve