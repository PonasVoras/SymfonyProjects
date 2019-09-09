<?php

namespace App\Entity;

class Order
{
    /** @var string */
    private $id;

    /** @var string */
    private $street;

    /** @var string */
    private $postCode;

    /** @var string */
    private $city;

    /** @var string */
    private $country;

    /** @var string */
    private $shippingName;

    public function getShipping(): string
    {
        return 'ups';
    }
}