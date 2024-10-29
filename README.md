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

You can use the `InteractsWithComments` trait in any model you want to have comments. Once the ```InteractsWithComments``` trait is added to a model, you can add comments to it.


```php

use Mintellity\Comments\Traits\InteractsWithComments;
use Mintellity\Comments\Contracts\HasComments

class Post extends Model implements HasComments
{
    use InteractsWithComments;
}

```

By adding the ```InteractsWithComments``` trait the model can now have comments attached to it.


Make sure the model that gets commented on has the ```HasComments``` interface in the model class. 
The ```WritesComments``` interface needs to be used in the class that writes a comment.
```php
use Mintellity\Comments\Contracts\WritesComments;
use Mintellity\Comments\Traits\InteractsWithComments;

class User extends Model implements WritesComments
{
    use InteractsWithComments;
    
    public function getName()
    {
        // Include your logic to receive the name of the user
    }
}
```

By adding the ```InteractsWithComments``` trait the function ```getName()``` can be used.

## Use comment-section

Display the comments for a model instance using the comment-section component. It includes a form to add a new comment and a list of comments attached to the model.

```html
<livewire:comment-section :model="$model" :author="$author"/>
```

The ```$model``` variable is the model instance that you want to display comments for. The ```$author``` variable is the user instance that is adding the comment.

## Examples

### Display comment section under a video

```html
<livewire:comment-section :model="App\Models\Video::first()" :author="auth()->userable->user()"/>
```


## Credits

- [Mintellity](https://github.com/mintellity)

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.