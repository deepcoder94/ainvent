<?php

use App\Models\Distributor;

if (! function_exists('checkDevMode')) {
    function checkDevMode() {
        $dist = Distributor::get()->first();
        return $dist->dev_mode;
    }
}