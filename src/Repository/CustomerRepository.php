<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Customer;

/**
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class CustomerRepository extends AbstractServiceEntityRepository implements CustomerInterface
{
    // Set entity class to ServiceEntityRepository parent
    protected string $entityClass = Customer::class;

    /**
     * Get all customers
     *
     * @return array
     */
    public function getAll(): array
    {
        return $this->createQueryBuilder('c')->getQuery()->getArrayResult();
    }
}
