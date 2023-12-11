<?php

namespace App\Console\Commands;

use App\Models\ExternalApplication;
use Illuminate\Console\Command;

class ShowExternalAppsCommand extends Command
{
    protected $signature = 'show:external-apps';

    protected $description = 'Command description';

    public function handle(): void
    {
        foreach (ExternalApplication::get() as $app) {
            $this->info("[$app->id] $app->name");
            $this->comment("Tokens");
            foreach ($app->tokens as $i => $token) {
                $this->line("[$i] " . $token->token);
            }
        }
    }
}
