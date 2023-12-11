<?php

namespace App\Console\Commands;

use App\Models\ExternalApplication;
use Illuminate\Console\Command;

class RemoveExternalAppCommand extends Command
{
    protected $signature = 'remove:external-app';

    protected $description = 'Command description';

    public function handle(): void
    {
        if ($id = $this->ask('Enter id or skip for enter name')) {
            if ($id = (int)$id) {
                if ($app = ExternalApplication::where(['id' => $id])->get()->first()) {
                    if ($app->delete()) {
                        $this->info('Success deleted');
                    } else {
                        $this->error('Failed delete');
                    }
                } else {
                    $this->error('No records with id data were found');
                }
            } else {
                $this->error('Incorrect id');
            }
        } else if ($name = $this->ask('Enter name or skip for cancel')) {
            if ($app = ExternalApplication::where(['name' => $name])->get()->first()) {
                if ($app->delete()) {
                    $this->info('Success deleted');
                } else {
                    $this->error('Failed delete');
                }
            } else {
                $this->error('No records with name data were found');
            }
        }
    }

    private function removeById(int $id)
    {

    }
}
