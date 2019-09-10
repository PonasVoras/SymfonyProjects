<?php

namespace App\Utils\OrderRegistrationApi;

class RegistrationApiHelper
{
    private $responseData;

    public function sendRegistrationRequest(
        string $requestData,
        string $uri,
        string $token
    )
    {
        $registrationApi = new RegistrationApi();
        $this->responseData = $registrationApi->sendRequest(
            $requestData, $uri, $token);
    }

    public function getResponseValue(
        string $responseData,
        string $value): string
    {
        $responseArray = json_decode($responseData, true);
        $value = $responseArray[$value];
        return $value;
    }
}