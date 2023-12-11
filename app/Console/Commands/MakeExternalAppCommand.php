<?php

namespace App\Console\Commands;

use App\Models\ExternalApplication;
use Illuminate\Console\Command;

class MakeExternalAppCommand extends Command
{
    protected $signature = 'make:external-app {name}';

    protected $description = 'Command description';

    public function handle(): void
    {
        $name = $this->argument('name');
        $app = ExternalApplication::create(['name' => $name]);
        $token = $app->createToken($name);
        $this->info("A token has been created for the $name application;" . PHP_EOL . "TOKEN: " . $token->plainTextToken);
    }
}
