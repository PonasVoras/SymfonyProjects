<?php
declare(strict_types=1);

namespace App\Services\OrderRegistration;

use App\Entity\Order as OrderEntity;
use App\Services\OrderRegistration\Interfaces\HandleCarrierInterfaceStrategy;
use App\Utils\OrderRegistrationApi;
use Psr\Log\LoggerInterface;

class HandleOmnivaCarrier implements HandleCarrierInterfaceStrategy
{
    private $orderRegistrationApi;
    private $logger;
    const PICKUP_POINT_ID_URI = 'omnivafake.com/pickup/find';
    const REGISTER_URI = 'omnivafake.com/register';

    public function __construct(
        LoggerInterface $logger
    )
    {
        $this->orderRegistrationApi = new OrderRegistrationApi();
        $this->logger = $logger;
    }

    /**
     * @param OrderEntity $orderEntity
     * @return string
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    protected function getPickupPointIdFromApi(OrderEntity $orderEntity): string
    {
        $responseDataFromApi = $this->orderRegistrationApi
            ->getResponseData($this->formPickupPointDataJson($orderEntity), self::PICKUP_POINT_ID_URI);
        $responseDataFromApi = json_decode($responseDataFromApi, true);
        $pickupPointId = $responseDataFromApi['status'];
        //in fact it should be :
        //$pickupPointId = $responseDataFromApi['pickup_point_id'];
        //but it is required to keep it as static as can be
        $this->logger->info('Received pickup point id ' . $pickupPointId);
        return $pickupPointId;
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

    /**
     * @param OrderEntity $orderEntity
     * @return string
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function formShippingDataJson(OrderEntity $orderEntity): string
    {
        $shippingData = array(
            'pickup_point_id' => $this->getPickupPointIdFromApi($orderEntity),
            'order_id' => $orderEntity->getId()
        );
        $shippingDataJson = json_encode($shippingData);
        return $shippingDataJson;
    }
}
