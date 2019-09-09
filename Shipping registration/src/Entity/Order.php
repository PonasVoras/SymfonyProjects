<?php

namespace App\Entity;

class Order
{
    /** @var string */
    private $id = "";

    /** @var string */
    private $street = "";

    /** @var string */
    private $postCode = "";

    /** @var string */
    private $city = "";

    /** @var string */
    private $country = "";

    /** @var string */
    private $shippingName;

    public function getId(): string
    {
        return $this->id;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getPostCode(): string
    {
        return $this->postCode;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getShippingCarrierName(): string
    {
        empty($this->shippingName) ?
            $shippingCarrierName = 'ups' :
            $shippingCarrierName = $this->shippingName;
        return $shippingCarrierName;
    }
}