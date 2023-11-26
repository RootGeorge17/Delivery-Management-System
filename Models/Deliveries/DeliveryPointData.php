<?php

class DeliveryPointData
{
    protected $id, $name, $address_1, $address_2, $postcode, $deliverer, $lat, $lng, $status, $del_photo;

    public function __construct($dbRow)
    {
        $this->id = $dbRow['id'];
        $this->name = $dbRow['name'];
        $this->address_1 = $dbRow['address_1'];
        $this->address_2 = $dbRow['address_2'];
        $this->postcode = $dbRow['postcode'];
        $this->deliverer = $dbRow['deliverer'];
        $this->lat = $dbRow['lat'];
        $this->lng = $dbRow['lng'];
        $this->status = $dbRow['status'];
        $this->del_photo = $dbRow['del_photo'];
    }

    public function getPointId()
    {
        return $this->id;
    }

    public function getPointName()
    {
        return $this->name;
    }

    public function getPointAddress1()
    {
        return $this->address_1;
    }

    public function getPointAddress2()
    {
        return $this->address_2;
    }

    public function getPointPostcode()
    {
        return $this->postcode;
    }

    public function getPointDeliverer()
    {
        return $this->deliverer;
    }

    public function getPointLat()
    {
        return $this->lat;
    }

    public function getPointLng()
    {
        return $this->lng;
    }

    public function getPointStatus()
    {
        return $this->status;
    }

    public function getPointDelPhoto()
    {
        return $this->del_photo;
    }
}