# Econt Composer Package
Econt courier services intergration in Laravel 5.1+ composer package.

This package supplies basic functionality for Econt integration inside Laravel applications. The implementation also has
migrations and database installation logic to maintain up to date local copy of Econt addressing database. This is a
requirement in order to have a good service with minimum response time. An update command is present to keep this local
copy up to date. Although, the database is updated rarely and some resources like regions - extremely rarely, it is
recommended to add it in the laravel task scheduler/runner.

## Installation
The package is development phase and there is no officially stable versions.
You can simply install the package by manually adding the dependecy in `composer.json` in `require` section:

`"rolice/econt": "dev-master"`
 
Or by typing:

`composer require rolice/econt dev-master`

## Configuration
After successful installation of the composer package you have to register the service provider in Laravel and to
publish the resources of the package. It is extremely easily. First step required is to add the service provider in the
application config - `config/app.php` in the section `providers`. Just add an array entry line below:

`Rolice\Econt\EcontServiceProvider::class`

After completing previous point the package is now operational inside the Laravel installation and publish of the
resource can be done. This publishing is performed by the Laravel artisan command like:

`php /path/to/laravel/project's/artisan/file vendor:publish`

The command will publish all the assets of all the packages. You can specify provider in the --provider option of that
command. For more information refer to official help by executing: `php artisan help vendor:publish`.