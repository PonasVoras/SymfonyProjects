<?php

namespace App\Services\OrderRegistration;

use App\Entity\Order as OrderEntity;
use App\Services\OrderRegistration\Interfaces\HandleCarrierInterfaceStrategy;
use App\Utils\OrderRegistrationApi;
use Psr\Log\LoggerInterface;

class HandleOmnivaCarrier implements HandleCarrierInterfaceStrategy
{
    protected $orderEntity;
    private $orderRegistrationApi;
    private $logger;
    const PICKUP_POINT_ID_URI = 'omnivafake.com/pickup/find';
    const REGISTER_URI = 'omnivafake.com/register';

    public function __construct(
        LoggerInterface $logger
    )
    {
        $this->orderEntity = new OrderEntity();
        $this->orderRegistrationApi = new OrderRegistrationApi();
        $this->logger = $logger;
    }

    /**
     * @return string
     //* @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    protected function getPickupPointIdFromApi(): string
    {
        $responseDataFromApi = $this->orderRegistrationApi
            ->getResponseData($this->formPickupPointDataJson(), self::PICKUP_POINT_ID_URI);
        $responseDataFromApi = json_decode($responseDataFromApi, true);
        $pickupPointId = $responseDataFromApi['status'];
        //in fact it should be :
        //$pickupPointId = $responseDataFromApi['pickup_point_id'];
        //but it is required to keep it as static as can be
        $this->logger->info('Received pickup point id ' . $pickupPointId);
        return $pickupPointId;
    }

    protected function formPickupPointDataJson(): string
    {
        $shippingData = array(
            'country' => $this->orderEntity->getCountry(),
            'post_code' => $this->orderEntity->getPostCode()
        );
        $shippingDataJson = json_encode($shippingData);
        return $shippingDataJson;
    }

    public function formShippingDataJson(): string
    {
        $shippingData = array(
            'pickup_point_id' => $this->getPickupPointIdFromApi(),
            'order_id' => $this->orderEntity->getId()
        );
        $shippingDataJson = json_encode($shippingData);
        return $shippingDataJson;
    }
}
