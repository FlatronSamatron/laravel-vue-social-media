# initialization project: 

## install laravel version 10 by sail in windows 10:

- `boot docker`
- `use wsl2 terminal`
- `curl -s "https://laravel.build/example-app?php=81" | bash`
- `explorer.exe .` -> open folder in windows
- `./vendor/bin/sail up -d` -> start container
  - `./vendor/bin/sail stop` -> stop container
  - `./vendor/bin/sail down` -> delete container
- `sudo chmod -R 777 .` -> make all files writable
- `composer require laravel/breeze --dev`
- `./vendor/bin/sail bash` -> use bash by sail
- `npm run dev`

## Generate Models and Migrations

- `php artisan make:model Post -m` -> generate model and migration of Posts
- `php artisan make:model PostAttachment -m` -> generate model and migration of PostAttachments
- `php artisan make:model PostReaction -m` -> generate model and migration of PostReactions
- `php artisan make:model Comment -m` -> generate model and migration of Comments
- `php artisan make:model GroupUser -m` -> generate model and migration of GroupUsers
- `php artisan make:model Follower -m` -> generate model and migration of Followers
- `php artisan make:migration add_columns_to_users_table` -> add_columns_to_users_table
- `php artisan migrate` -> crate tables

## Generate Unique Username on Registration

- `composer require spatie/laravel-sluggable` ->  [Generate slugs when saving Eloquent models](https://github.com/spatie/laravel-sluggable)
- add to User model:
  - implements MustVerifyEmail
  - getSlugOptions()
- `localhost:8025` -> mailpit - email verify service  
- add to UpdateProfileInformationForm.vue username field
- add to ProfileUpdateRequest.php username field
  - add messages which react to regex

## Create Home Page UI with Tailwind.css

- `php artisan make:controller HomeController` -> generate controller HomeController




