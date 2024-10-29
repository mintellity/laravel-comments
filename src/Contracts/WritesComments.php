<?php

namespace Mintellity\Comments\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface WritesComments
{
    /**
     * @return MorphMany
     */
    public function writesComment(): MorphMany;

    public function getName(): string;
}