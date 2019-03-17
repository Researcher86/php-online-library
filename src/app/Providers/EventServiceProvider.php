<?php

namespace App\Providers;

use App\Events\BookUploadEvent;
use App\Events\SendEmailEvent;
use App\Events\SendSmsEvent;
use App\Listeners\BookUploadListener;
use App\Listeners\SendEmailListener;
use App\Listeners\SendSmsListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        BookUploadEvent::class => [
            BookUploadListener::class,
        ],
        SendEmailEvent::class => [
            SendEmailListener::class,
        ],
        SendSmsEvent::class => [
            SendSmsListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
