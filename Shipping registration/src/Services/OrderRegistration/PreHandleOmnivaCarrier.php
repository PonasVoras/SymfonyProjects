<?php
declare(strict_types=1);

namespace App\Services\OrderRegistration;

use App\Entity\Order as OrderEntity;
use App\Services\OrderRegistration\Interfaces\HandleCarrierInterfaceStrategy;
use App\Utils\OrderRegistrationApi\RegistrationApiHelper;

class PreHandleOmnivaCarrier implements HandleCarrierInterfaceStrategy
{
    const PICKUP_POINT_ID_URI = 'omnivafake.com/pickup/find';
    const TOKEN = 'token';
    const REQUIRED_PARAMETER = 'pickup_point_id';
    private $orderRegistrationApiHelper;

    public function __construct()
    {
        $this->orderRegistrationApiHelper = new RegistrationApiHelper();
    }

    public function prepareRequestDataJson(OrderEntity $orderEntity): string
    {
        $shippingData = array(
            'country' => $orderEntity->getCountry(),
            'post_code' => $orderEntity->getPostCode()
        );
        $shippingDataJson = json_encode($shippingData);
        return $shippingDataJson;
    }

    protected function getPickupPointIdFromApi(): string
    {
        $this->orderRegistrationApiHelper->forwardRequest($this);
        $pickupPointId = $this->orderRegistrationApiHelper
            ->getResponseValue($this->getRequiredParameter());
        return $pickupPointId;
    }

    public function getPickupPointId(){
        $pickupPointId = $this->getPickupPointIdFromApi();
        return $pickupPointId;
    }

    public function canHandleCarrier(string $carrierName)
    {
        // TODO: Implement canHandleCarrier() method.
    }

    public function getUri(): string
    {
        return self::PICKUP_POINT_ID_URI;
    }

    public function getToken(): string
    {
        return self::TOKEN;
    }

    public function getRequiredParameter(): string
    {
        return self::REQUIRED_PARAMETER;
    }
}