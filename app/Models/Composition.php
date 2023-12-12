<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Composition extends Model
{

    protected $fillable = [
        'name', 'description'
    ];

    public function composers(): BelongsToMany
    {
        return $this->belongsToMany(Composer::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(CompositionFile::class);
    }

    static function saveBase64File($data, $name) {

    }
}
