<?php
declare(strict_types=1);

namespace App\Utils\OrderRegistrationApi;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RegistrationApi
{
    public function sendRequest(
        string $requestData,
        string $uri,
        string $token): string
    {
        empty($token) ?
            $client = $this->createClient() :
            $client = $this->createAuthClient($token);

        try {
            $response = $client->request('POST', 'https://' . $uri, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => $requestData
            ]);
        } catch (TransportExceptionInterface $e) {
            echo 'Api failure';
        }

        if ($response->getStatusCode() !== 200){
            $response = $response->getContent();
        } else{
            throw  new  Exception('Request failure');
        }

        return $response;
    }

    public function createClient(): HttpClientInterface
    {
        return HttpClient::create();
    }

    public function createAuthClient(string $token): HttpClientInterface
    {
        return HttpClient::create(['auth_bearer' => $token]);
    }


}