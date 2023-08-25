<?php

namespace ProgrammeruzPayme\PaymentPackage;

use Illuminate\Support\ServiceProvider;
class ProgrammerPaymentServiceProvider extends ServiceProvider
{
    public function boot(){
        $this->loadRoutesFrom(__DIR__ . "/routes/api.php");
    }

}