<?php


namespace PaylandsSDK\Types;

/**
 * Class CustomerCard
 * @package PaylandsSDK\Types
 */
class CustomerCard
{
    /**
     * @var Customer
     */
    private $Customer;
    /**
     * @var Card
     */
    private $Source;

    /**
     * CustomerCard constructor.
     * @param Customer $customer
     * @param Card $source
     */
    public function __construct(Customer $customer, Card $source)
    {
        $this->Customer = $customer;
        $this->Source = $source;
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->Customer;
    }

    /**
     * @param Customer $Customer
     * @return CustomerCard
     */
    public function setCustomer(Customer $Customer): CustomerCard
    {
        $this->Customer = $Customer;
        return $this;
    }

    /**
     * @return Card
     */
    public function getSource()
    {
        return $this->Source;
    }

    /**
     * @param Card $Source
     * @return CustomerCard
     */
    public function setSource(Card $Source): CustomerCard
    {
        $this->Source = $Source;
        return $this;
    }
}
