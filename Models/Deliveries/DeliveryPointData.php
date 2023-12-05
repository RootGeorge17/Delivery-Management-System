<?php
/**
 * Class DeliveryPointData
 * Represents delivery point data fetched from the database.
 */
class DeliveryPointData
{
    protected $id, $name, $address_1, $address_2, $postcode, $deliverer, $lat, $lng, $status, $del_photo;
    protected $delivererUsername;

    /**
     * Constructs a DeliveryPointData object from a database row.
     *
     * @param array $dbRow The database row containing delivery point information.
     */
    public function __construct($dbRow)
    {
        $this->id = $dbRow['id'];
        $this->name = $dbRow['name'];
        $this->address_1 = $dbRow['address_1'];
        $this->address_2 = $dbRow['address_2'];
        $this->postcode = $dbRow['postcode'];
        $this->deliverer = $dbRow['deliverer'];
        //$this->delivererUsername = $dbRow['deliverer_username'];
        $this->lat = $dbRow['lat'];
        $this->lng = $dbRow['lng'];
        $this->status = $dbRow['status'];
        $this->del_photo = $dbRow['del_photo'];
    }

    // Getter methods for various delivery point attributes

    /**
     * Get the delivery point ID.
     *
     * @return mixed The delivery point ID.
     */
    public function getPointId()
    {
        return $this->id;
    }

    /**
     * Get the delivery point name.
     *
     * @return mixed The delivery point name.
     */
    public function getPointName()
    {
        return $this->name;
    }

    /**
     * Get the delivery point address line 1.
     *
     * @return mixed The delivery point address line 1.
     */
    public function getPointAddress1()
    {
        return $this->address_1;
    }

    /**
     * Get the delivery point address line 2.
     *
     * @return mixed The delivery point address line 2.
     */
    public function getPointAddress2()
    {
        return $this->address_2;
    }

    /**
     * Get the delivery point postcode.
     *
     * @return mixed The delivery point postcode.
     */
    public function getPointPostcode()
    {
        return $this->postcode;
    }

    /**
     * Get the ID of the deliverer.
     *
     * @return mixed The ID of the deliverer.
     */
    public function getPointDeliverer()
    {
        return $this->deliverer;
    }

    /**
     * Get the username of the deliverer.
     *
     * @return mixed The username of the deliverer.
     */
    public function getPointDelivererUsername()
    {
        return $this->delivererUsername;
    }

    /**
     * Get the latitude of the delivery point.
     *
     * @return mixed The latitude of the delivery point.
     */
    public function getPointLat()
    {
        return $this->lat;
    }

    /**
     * Get the longitude of the delivery point.
     *
     * @return mixed The longitude of the delivery point.
     */
    public function getPointLng()
    {
        return $this->lng;
    }


    /**
     * Get the delivery status of the point.
     *
     * @return string The delivery status.
     */
    public function getPointStatus()
    {
        if ($this->status == '1') {
            return 'Pending';
        } else if ($this->status == '2') {
            return 'Shipped';
        } else if ($this->status == '3') {
            return 'Out for delivery';
        } else if ($this->status == '4') {
            return 'Delivered';
        }
    }

    /**
     * Get the delivery photo of the point.
     *
     * @return mixed The delivery photo of the point.
     */
    public function getPointDelPhoto()
    {
        return $this->del_photo;
    }
}