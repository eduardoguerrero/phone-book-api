<?php
declare(strict_types=1);

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class AbstractServiceEntityRepository
 * @package App\Repository
 */
abstract class AbstractServiceEntityRepository extends ServiceEntityRepository
{

    /** @var string */
    protected string $entityClass;

    /**
     * @param ManagerRegistry $registry
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(ManagerRegistry $registry, protected EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, $this->entityClass);
    }

    /**
     * @return void
     */
    public function flushEntity(): void
    {
        $this->_em->flush();
    }

    /**
     * @param $object
     * @return mixed
     */
    public function persistEntity($object): mixed
    {
        $this->_em->persist($object);

        return $object;
    }

    /**
     * @return void
     */
    public function clearEntity(): void
    {
        $this->_em->clear();
    }

    /**
     * @param $object
     * @return void
     */
    public function removeEntity($object): void
    {
        $this->_em->remove($object);
    }

}
