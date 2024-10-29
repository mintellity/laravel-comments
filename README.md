# Comment Package for Laravel.

This is a package to include a comment section in your Laravel application.

# Installation

You can install the package via composer:

```bash
composer require mintellity/laravel-comments
```

You can publish the migration file with:
```bash
php artisan laravel-comments:install
```


# Usage

You can use the `InteractsWithComments` trait in any model you want to have comments.

```php

use Mintellity\Comments\Traits\InteractsWithComments;
use Mintellity\Comments\Contracts\HasComments

class Post extends Model implements HasComments
{
    use InteractsWithComments;
}

```

By adding the ```InteractsWithComments``` trait the model can now have comments attached to it.


You can also add the ```HasComments``` trait to the User model to get all the comments made by the user.

```php
use Mintellity\Comments\Contracts\WritesComments;

class User extends Model implements WritesComments
{
    use WritesComments;
    
    public function getName()
    {
        // Include your logic to receive the name of the user
    }
}
```

Once the ```InteractsWithComments``` trait is added to a model, you can add comments to it.

## Use comment-section

Display the comments for a model instance using the comment-section component. It includes a form to add a new comment and a list of comments attached to the model.

```html
<livewire comment-section :model="$model" :author="$author"/>
```

The ```$model``` variable is the model instance that you want to display comments for. The ```$author``` variable is the user instance that is adding the comment.

## Examples

### Display comment section under a video

```html
<livewire:comment-section :model="App\Models\Video" :author="auth()->userable->user()"/>
```


## Credits

- [Mintellity](https://github.com/mintellity)

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.