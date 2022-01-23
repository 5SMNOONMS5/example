# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/stephenchen/core.svg?style=flat-square)](https://packagist.org/packages/stephenchen/core)
[![Total Downloads](https://img.shields.io/packagist/dt/stephenchen/core.svg?style=flat-square)](https://packagist.org/packages/stephenchen/core)
![GitHub Actions](https://github.com/stephenchen/core/actions/workflows/main.yml/badge.svg)

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what PSRs you support to avoid any confusion with users and contributors.

## Installation

You can install the package via composer:

```bash
composer require stephenchen/core
```

or locally

```bash
"require": {
    .
    .
    .
    "stephenchen/core": "dev-main"
},
```

## Composer install first

```bash
composer install
```

## In config/auth.php

```php
<?php

use Stephenchen\Core\Http\Backend\Admin\AdminModel;

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard'     => 'admins',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here which uses session storage and the Eloquent user provider.
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | Supported: "session", "token"
    |
    */

    'guards' => [
        'web' => [
            'driver'   => 'session',
            'provider' => 'users',
        ],

        'users' => [
            'driver'   => 'jwt',
            'provider' => 'users',
        ],

        'admins' => [
            'driver'   => 'jwt',
            'provider' => 'admins',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | If you have multiple user tables or models you may configure multiple
    | sources which represent each model / table. These sources may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model'  => UserModel::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model'  => AdminModel::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | You may specify multiple password reset configurations if you have more
    | than one user table or model in the application and you want to have
    | separate password reset settings based on the specific user types.
    |
    | The expire time is the number of minutes that the reset token should be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table'    => 'password_resets',
            'expire'   => 60,
        ],

        'admins' => [
            'provider' => 'admins',
            'table'    => 'password_resets',
            'expire'   => 60,
        ],
    ],
];
```

## Run seeder

In DatabaseSeeder

```php
$this->call(CoreSeeder::class);
```

## Init

In DatabaseSeeder

```php
$this->call(CoreSeeder::class);
```

## Publish

```bash
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
php artisan vendor:publish --provider "Spatie\Permission\PermissionServiceProvider"
php artisan vendor:publish --provider "Prettus\Repository\Providers\RepositoryServiceProvider"
```

## Copy into l5-swagger

```php
'annotations'            => [
    base_path() . '/packages/stephenchen/core/src',
]
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email tasb00429@gmail.com instead of using the issue tracker.

## Credits

-   [Stephen chen](https://github.com/stephenchen)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
