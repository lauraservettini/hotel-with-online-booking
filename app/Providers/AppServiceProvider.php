<?php

namespace App\Providers;

use App\Models\SmtpSettings;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (Schema::hasTable('smtp_settings')) {
            $smtpSettings = SmtpSettings::first();

            if ($smtpSettings) {
                $data = [
                    'driver' => $smtpSettings->mailer,
                    'host' => $smtpSettings->host,
                    'port' => $smtpSettings->port,
                    'username' => $smtpSettings->username,
                    'password' => $smtpSettings->password,
                    'encryption' => $smtpSettings->encryption,
                    'form' => [
                        'address' => $smtpSettings->form_address,
                    ]
                ];

                Config::set('mail', $data);
            }
        }
    }
}
