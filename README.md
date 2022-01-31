## Simple Laravel React Blog

## About

This is just a basic blog implementation using Laravel and ReactJs framework.

## Set up
Clone this repository, navigate to the repository root and run the following commands
1. Install dependencies
```bash
    composer install
```
2. Run migration
```bash
    php artisan migrate
```
3. Seed Data
```bash
    php artisan db:seed
```
4. Start application
```bash
    php artisan serve
```
## Credentials

If you followed the steps above, you can login to any account with **test** as password, else you will have to register and login with your credentials

```bash
    default password is test
```

## Required PHP version
^7.4 | ^8.0
## Testing
Run the command below at the root directory of the project
```bash
    ./vendor/bin/phpunit
```
