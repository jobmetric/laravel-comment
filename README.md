[contributors-shield]: https://img.shields.io/github/contributors/jobmetric/laravel-comment.svg?style=for-the-badge
[contributors-url]: https://github.com/jobmetric/laravel-comment/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/jobmetric/laravel-comment.svg?style=for-the-badge&label=Fork
[forks-url]: https://github.com/jobmetric/laravel-comment/network/members
[stars-shield]: https://img.shields.io/github/stars/jobmetric/laravel-comment.svg?style=for-the-badge
[stars-url]: https://github.com/jobmetric/laravel-comment/stargazers
[license-shield]: https://img.shields.io/github/license/jobmetric/laravel-comment.svg?style=for-the-badge
[license-url]: https://github.com/jobmetric/laravel-comment/blob/master/LICENCE.md
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-blue.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://linkedin.com/in/majidmohammadian

[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![MIT License][license-shield]][license-url]
[![LinkedIn][linkedin-shield]][linkedin-url]

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

When you add this class, you will have to implement `CommentContract` to your model.

```php
use JobMetric\Comment\Contracts\CommentContract;

class Post extends Model implements CommentContract
{
    use HasComment;
}
```

Now you have to use the needsCommentApproval function, and you have to add it to your model.

```php
use JobMetric\Comment\Contracts\CommentContract;

class Post extends Model implements CommentContract
{
    use HasComment;

    public function needsCommentApproval(): bool
    {
        return false;
    }
}
```

## How is it used?

You can now use the `HasComment` class for your model.

#### Store comment

You can store a new comment by using the following code:

```php
$post = Post::create([
    'title' => 'Post title',
    'body' => 'Post body',
]);

$post->comment('This is a comment', $parent_comment_id, $user_id);
```

> If you want to store a comment without a parent comment, you can pass `null` to the second parameter.
> 
> If you want to store a comment without a user, you can pass `null` to the third parameter.

#### Update comment

You can update an existing comment by using the following code:

```php
$post->updateComment($comment->id, 'This is a new comment');
```

#### Forget comment

You can forget an existing comment by using the following code:

```php
$post->forgetComment($comment->id);
```

#### Forget all comments

You can forget all comments by using the following code:

```php
$post->forgetComments();
```

#### Get comments

You can get all comments by using the following code:

```php
$comments = $post->comments;
```

#### Get approved comments

You can get all approved comments by using the following code:

```php
$comments = $post->approvedComments;
```

#### Get unapproved comments

You can get all unapproved comments by using the following code:

```php
$comments = $post->unapprovedComments;
```

#### Get parent comments

You can get all parent comments by using the following code:

```php
$comments = $post->parentComments;
```

## CanComment trait

You can also connect the `CanComment` trait class to your User model.

```php
use JobMetric\Comment\CanComment;

class User extends Authenticatable
{
    use CanComment;
}
```

## Events

This package contains several events for which you can write a listener as follows

| Event                | Description                                        |
|----------------------|----------------------------------------------------|
| `CommentStoredEvent` | This event is called after storing the comment.    |
| `CommentUpdateEvent` | This event is called after updating the comment.   |
| `CommentForgetEvent` | This event is called after forgetting the comment. |


## Contributing

Thank you for considering contributing to the Laravel Comment! The contribution guide can be found in the [CONTRIBUTING.md](https://github.com/jobmetric/laravel-comment/blob/master/CONTRIBUTING.md).

## License

The MIT License (MIT). Please see [License File](https://github.com/jobmetric/laravel-comment/blob/master/LICENCE.md) for more information.
