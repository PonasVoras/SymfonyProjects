<?php
declare(strict_types=1);

namespace App\Services\OrderRegistration\Interfaces;

use App\Entity\Order as OrderEntity;

interface HandleCarrierInterfaceStrategy
{
    public function formShippingDataJson(OrderEntity $orderEntity): string;
}