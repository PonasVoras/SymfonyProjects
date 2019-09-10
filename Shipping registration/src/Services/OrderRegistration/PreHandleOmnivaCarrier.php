<?php
declare(strict_types=1);

namespace App\Services\OrderRegistration;

use App\Entity\Order as OrderEntity;
use App\Utils\OrderRegistrationApi\RegistrationApiHelper;
use Psr\Log\LoggerInterface;

class PreHandleOmnivaCarrier
{
    private $logger;
    const PICKUP_POINT_ID_URI = 'omnivafake.com/pickup/find';
    const TOKEN = 'token';
    const REQUIRED_PARAMETER = 'pickup_point_id';
    private $orderRegistrationApiHelper;

    public function __construct(
        LoggerInterface $logger
    )
    {
        $this->orderRegistrationApiHelper = new RegistrationApiHelper();
        $this->logger = $logger;
    }

    protected function formPickupPointDataJson(OrderEntity $orderEntity): string
    {
        $shippingData = array(
            'country' => $orderEntity->getCountry(),
            'post_code' => $orderEntity->getPostCode()
        );
        $shippingDataJson = json_encode($shippingData);
        return $shippingDataJson;
    }

    protected function getPickupPointIdFromApi(string $shippingData): string
    {
        $pickupPointId = $this->orderRegistrationApiHelper
            ->getResponseValue(
                $shippingData,
                self::PICKUP_POINT_ID_URI,
                self::TOKEN,
                self::REQUIRED_PARAMETER);
        $this->logger->info('Received pickup point id ' . $pickupPointId);
        return $pickupPointId;
    }

    public function getPickupPointId(OrderEntity $orderEntity){
        $shippingData = $this->formPickupPointDataJson($orderEntity);
        $pickupPointId = $this->getPickupPointIdFromApi($shippingData);
        return $pickupPointId;
    }

}