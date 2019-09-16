<?php

namespace App\Tests\Unit\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class OrderControllerTest extends WebTestCase
{
    public function testControllerShouldReturnOkResponse()
    {
        $client = $this->makeClient();
        $client->request('GET', '/');
        $this->assertStatusCode(200, $client);
    }

}
