<?php
declare(strict_types=1);

namespace App\Utils\OrderRegistrationApi;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RegistrationApi
{
    /**
     * @param string $requestData
     * @param string $uri
     * @param string $token
     * @return string|Exception
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function sendRequest(
        string $requestData,
        string $uri,
        string $token): string
    {
        empty($token) ?
            $client = $this->createClient() :
            $client = $this->createAuthClient($token);
        $response = $client->request('POST', 'https://' . $uri, [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => $requestData
        ]);

        if ($response->getStatusCode() == 200) {
            return $response->getContent();
        }
        throw new Exception('Wrong status code received :'
        . $response->getStatusCode());
    }

    private function createClient(): HttpClientInterface
    {
        return HttpClient::create();
    }

    private function createAuthClient(string $token): HttpClientInterface
    {
        return HttpClient::create(['auth_bearer' => $token]);
    }


}