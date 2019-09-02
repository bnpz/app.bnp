<?php


namespace App\Service\Customer\Customer;

use App\Contract\Service\Customer\CustomerServiceInterface;
use App\Entity\Customer\Customer;
use App\Repository\Customer\CustomerRepository;
use App\Service\Base\AbstractEntityService;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Ramsey\Uuid\UuidInterface;

/**
 * Class CustomerService
 * @package App\Service\Customer\Customer
 */
class CustomerService extends AbstractEntityService implements CustomerServiceInterface
{
    /**
     * @var CustomerRepository
     */
    protected $repository;

    public function __construct(
        ManagerRegistry $managerRegistry,
        CustomerRepository $customerRepository
    )
    {
        parent::__construct($managerRegistry);
        $this->repository = $customerRepository;
    }

    /**
     * @return string
     */
    protected function getEntityClassName()
    {
        return Customer::class;
    }

    /**
     * @param Customer $transferEntity
     * @param Customer|null $managedEntity
     * @return Customer
     * @throws EntityNotFoundException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Customer $transferEntity, ?Customer $managedEntity)
    {
        if($transferEntity->getId() !== "") {
            $managedEntity = isset($managedEntity) ? $managedEntity : $this->get($transferEntity->getId());
        }

        if (isset($managedEntity)){
            return $this->update($managedEntity, $transferEntity);
        }

        return $this->create($transferEntity);
    }

    /**
     * @param Customer $transferEntity
     * @return Customer
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function create(Customer $transferEntity)
    {
        $managedEntity = Customer::init();
        $entity = $this->setFields($managedEntity, $transferEntity);
        $this->saveEntity($entity);
        return $entity;
    }

    /**
     * @param Customer $managedEntity
     * @param Customer $transferEntity
     * @return Customer
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function update(Customer $managedEntity, Customer $transferEntity)
    {
        $entity = $this->setFields($managedEntity, $transferEntity);
        $this->saveEntity($entity);
        return $entity;
    }

    /**
     * @param Customer $customer
     * @return void
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Customer $customer)
    {
        $this->deleteEntity($customer);
    }

    /**
     * @param UuidInterface | string $id
     * @return Customer
     * @throws EntityNotFoundException
     */
    public function findById(string $id)
    {
        return $this->get($id);
    }

    /**
     * @param Customer $managedEntity
     * @param Customer $transferEntity
     * @return Customer
     */
    private function setFields(Customer $managedEntity, Customer $transferEntity): Customer
    {
        $this->transcribe($transferEntity, $managedEntity, [
            'name',
            'phone',
            'email'
        ]);
        return $managedEntity;
    }

    /**
     * @return Customer[]
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }
}