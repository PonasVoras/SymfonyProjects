<?php

namespace App\Services\OrderRegistration\Interfaces;

interface HandleCarrierInterfaceStrategy
{
    public function formShippingDataJson(): string;
}