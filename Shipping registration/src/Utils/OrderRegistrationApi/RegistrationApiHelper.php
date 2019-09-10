<?php
declare(strict_types=1);

namespace App\Utils\OrderRegistrationApi;

use App\Entity\Order as OrderEntity;
use App\Services\OrderRegistration\Interfaces\HandleCarrierInterfaceStrategy;


// TODO Get handler data and put them intp request parameter
class RegistrationApiHelper
{
    private $registrationApi;
    private $orderEntity;
    private $requestDataArray;

    public function __construct()
    {
        $this->registrationApi = new RegistrationApi();
        $this->orderEntity = new OrderEntity();
    }

    public function register(HandleCarrierInterfaceStrategy $handler)
    {
        $token = $handler->getToken();
        $uri = $handler->getUri();
        $
        $this->registrationApi->sendRequest();
    }


    //takes handler object and prepares request data
    public function prepareRequestData()
    {

        return $requestDataArray;
    }

    public function getResponseValue(): string
    {
        $responseDataJson = $this->registrationApi->sendRequest($requestData, $uri, $token);
        $responseDataArray = json_decode($responseDataJson, true);
        $responseValue = $responseDataArray[$value];
        return $responseValue;
    }
}