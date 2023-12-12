<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompositionFile extends Model
{
    protected $appends = ['url'];
    protected $fillable = ['disk', 'path', 'composition_id', 'name'];
    protected $hidden = ['path', 'disk', 'composition_id'];

    public function getUrlAttribute(): string
    {
        return route('composition.file', [$this->id]);
    }
}
