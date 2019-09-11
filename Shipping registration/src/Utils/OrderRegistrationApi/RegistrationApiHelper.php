<?php
declare(strict_types=1);

namespace App\Utils\OrderRegistrationApi;

use App\Entity\Order as OrderEntity;
use App\Service\OrderRegistration\Interfaces\HandleCarrierInterfaceStrategy;

class RegistrationApiHelper
{
    private $registrationApi;
    private $orderEntity;
    private $responseDataJson;

    public function __construct()
    {
        $this->registrationApi = new RegistrationApi();
        $this->orderEntity = new OrderEntity();
    }

    public function forwardRequest(HandleCarrierInterfaceStrategy $handler)
    {
        $token = $handler->getToken();
        $uri = $handler->getUri();
        $body = $handler->prepareRequestDataJson($this->orderEntity);
        $responseDataJson = $this->registrationApi->sendRequest($body, $uri, $token);
        $this->responseDataJson = $responseDataJson;
    }

    public function getResponseValue($requiredParameter): string
    {
        $responseDataArray = json_decode($this->responseDataJson, true);
        $responseValue = $responseDataArray[$requiredParameter];
        return $responseValue;
    }
}