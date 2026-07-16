       # Inventory RBAC — Starter Application (NO RBAC yet)

A simple inventory system for Laravel 13 with Fortify authentication and core-CSS styling.
Any authenticated user can currently perform ALL actions. RBAC is added in the lab activity.

## Requirements
- PHP 8.3+, Composer, SQLite (bundled with PHP)

## Setup

1. Create a fresh Laravel 13 project:

       composer create-project laravel/laravel inventory-rbac
       cd inventory-rbac

2. Install Fortify:

       composer require laravel/fortify
       php artisan fortify:install

3. Copy the contents of this starter package into the project root,
   OVERWRITING files when prompted (routes/web.php, database/seeders/DatabaseSeeder.php,
   app/Providers/FortifyServiceProvider.php).

4. Configure Fortify — edit config/fortify.php:

       'home'     => '/inventory',
       'features' => [],            // login/logout only; registration disabled

5. Migrate and seed (SQLite database/database.sqlite is created automatically):

       php artisan migrate --seed

6. Serve:

       php artisan serve

## Demo accounts (password for all: `password`)

| Name              | Email                     |
|-------------------|---------------------------|
| System Admin      | admin@inventory.test      |
| Receiving Clerk   | clerk@inventory.test      |
| Inventory Manager | manager@inventory.test    |
| Supervisor        | supervisor@inventory.test |
| Reports Officer   | reports@inventory.test    |
