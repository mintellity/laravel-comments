<?php

namespace Mintellity\Comments\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface HasComments
{
    /**
     * @return MorphMany
     */
    public function comments(): MorphMany;
}