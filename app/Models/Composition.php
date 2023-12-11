<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Composition extends Model
{

    public function composers(): BelongsToMany
    {
        return $this->belongsToMany(Composer::class);
    }

    public function files(): BelongsToMany {
        return $this->belongsToMany(CompositionFile::class);
    }
}
