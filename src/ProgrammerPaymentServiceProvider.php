<?php

namespace ProgrammeruzPayme\PaymentPackage;

use Illuminate\Support\ServiceProvider;
class ProgrammerPaymentServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // ...
    }
    public function register()
    {
        $this->app->bind('Payment', function ($app) {
            return new Payment();
        });
    }
}