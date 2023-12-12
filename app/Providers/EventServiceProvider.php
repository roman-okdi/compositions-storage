<?php

namespace App\Providers;

use App\Models\Composition;
use App\Models\CompositionFile;
use App\Models\ExternalApplication;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        ExternalApplication::deleting(function (ExternalApplication $app) {
            foreach ($app->tokens as $token) {
                $token->delete();
            }
        });
        Composition::onDelete(function (Composition $model) {
            $disk = \Storage::disk('compositions');
            $disk->deleteDirectory($model->id);
            foreach ($model->files as $file) {
                $file->delete();
            }
        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
