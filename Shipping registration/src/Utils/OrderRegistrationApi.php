<?php
declare(strict_types=1);

namespace App\Utils;

//use Symfony\Component\HttpClient\HttpClient;

class OrderRegistrationApi
{
    /**
     * @param string $requestData
     * @param string $uri
     * @return false|string|\Symfony\Contracts\HttpClient\ResponseInterface
     * // * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function getResponseData(string $requestData, string $uri)
    {
        //$client = HttpClient::create();
        //$response = $client->request('POST', 'https://' . $uri,[
        //    'body' => $requestData
        //]);
        //$responseStatus = $response->getStatusCode();
        $responseData = array(
            //    'status' => $responseStatus
            'status' => '200'
        );
        $response = json_encode($responseData);
        return $response;
    }
}