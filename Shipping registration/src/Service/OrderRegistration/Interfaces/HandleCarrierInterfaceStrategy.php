<?php
declare(strict_types=1);

namespace App\Service\OrderRegistration\Interfaces;

use App\Entity\Order as OrderEntity;

interface HandleCarrierInterfaceStrategy
{
    public const SERVICE_TAG = 'registration_strategy';
    
    public function canHandleCarrier(string $carrierName);

    public function prepareRequestDataJson(OrderEntity $orderEntity): string;

    public function getUri(): string;

    public function getToken(): string;
}