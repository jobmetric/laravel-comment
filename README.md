# Comment for laravel

This is a comment management package for any object in Laravel that you can use in your projects.

## Install via composer

Run the following command to pull in the latest version:
```bash
composer require jobmetric/laravel-comment
```

## Documentation

This package evolves every day under continuous development and integrates a diverse set of features. It's a must-have asset for Laravel enthusiasts and provides a seamless way to align your projects with basic comment models.

In this package, you can use it seamlessly with any model that needs comments.

Now let's go to the main function.

>#### Before doing anything, you must migrate after installing the package by composer.

```bash
php artisan migrate
```

Meet the `HasComment` class, meticulously designed for integration into your model. This class automates essential tasks, ensuring a streamlined process for:

In the first step, you need to connect this class to your main model.

```php
use JobMetric\Comment\HasComment;

class Post extends Model
{
    use HasComment;
}
```

## How is it used?

You can now use the `HasComment` class for your model. The following example shows how to create a new post with comments:
