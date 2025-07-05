<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use Illuminate\Support\Facades\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    Config::set('mail.mailers.smtp.host', Setting::get('mail_host'));
    Config::set('mail.mailers.smtp.port', Setting::get('mail_port'));
    Config::set('mail.mailers.smtp.encryption', Setting::get('mail_encryption'));
    Config::set('mail.mailers.smtp.username', Setting::get('mail_username'));
    Config::set('mail.mailers.smtp.password', Setting::get('mail_password'));
    Config::set('mail.from.address', Setting::get('mail_from_address'));
    Config::set('mail.from.name', Setting::get('mail_from_name'));
    }
}
