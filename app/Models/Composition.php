<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Nette\Utils\FileSystem;
use Nette\Utils\Random;

class Composition extends Model
{

    const DISK_NAME = 'compositions';

    protected $fillable = [
        'name', 'description'
    ];

    protected $hidden = ['pivot'];

    public function composers(): BelongsToMany
    {
        return $this->belongsToMany(Composer::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(CompositionFile::class);
    }

    public function deleteFiles(): void
    {
        CompositionFile::where(['composition_id' => $this->id])->delete();
        Storage::disk(self::DISK_NAME)->deleteDirectory($this->id);
    }

    public function loadAllDependencies(): self
    {
        return $this->load('composers')->load('files');
    }

    public function saveFile(string $name, $data): ?CompositionFile
    {
        $disk = Storage::disk(self::DISK_NAME);
        $path = "$this->id/$name";
        while ($disk->exists($path)) {
            $pattern = "/(.*)(\.\w+$)/";
            $random = Random::generate(4);
            $path = preg_replace($pattern, "$1_$random$2", $path);
        }
        if ($disk->put($path, $data)) {
            return CompositionFile::create([
                'name' => $name,
                'disk' => self::DISK_NAME,
                'path' => $path,
                'composition_id' => $this->id
            ]);
        }
        return null;
    }
}
