<?php

namespace Mintellity\Comments\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'modelable_id',
        'modelable_type',
        'userable_id',
        'userable_type',
        'comment_content',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];


    // Relation to the Model that gets commented (e.g. Post, Video, etc.)
    public function modelable(): MorphTo
    {
        return $this->morphTo();
    }

    // Relation to the Entity that made the comment (e.g. User, Admin, etc.)
    public function userable(): MorphTo
    {
        return $this->morphTo();
    }
}