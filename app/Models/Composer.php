<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Composer extends Model
{

    protected $fillable = ['name', 'description'];

    protected $hidden = ['pivot'];
    public function compositions(): BelongsToMany
    {
        return $this->belongsToMany(Composition::class);
    }
}
