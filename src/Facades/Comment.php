<?php

namespace Mintellity\Comments\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mintellity\Comments\Comment
 */
class Comment extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Mintellity\Comments\Comment::class;
    }
}