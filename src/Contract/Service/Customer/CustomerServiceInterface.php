<?php

namespace App\Contract\Service\Customer;

use App\Entity\Customer\Customer;
use Ramsey\Uuid\UuidInterface;

interface CustomerServiceInterface
{
    /**
     * @param Customer $transferEntity
     * @param Customer|null $managedEntity
     * @return Customer
     */
    public function save(Customer $transferEntity, ?Customer $managedEntity);

    /**
     * @param Customer $transferEntity
     * @return Customer
     */
    public function create(Customer $transferEntity);

    /**
     * @param Customer $managedEntity
     * @param Customer $transferEntity
     * @return Customer
     */
    public function update(Customer $managedEntity, Customer $transferEntity);

    /**
     * @param Customer $customer
     * @return void
     */
    public function delete(Customer $customer);

    /**
     * @param UuidInterface | string $id
     * @return Customer
     */
    public function findById(string $id);

    /**
     * @return Customer[]
     */
    public function findAll();
}