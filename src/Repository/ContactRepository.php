<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Contact;

/**
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ContactRepository extends AbstractServiceEntityRepository implements ContactInterface
{
    // Set entity class to ServiceEntityRepository parent
    protected string $entityClass = Contact::class;

    /**
     * @param string $firstname
     * @param string $lastname
     * @return array
     */
    public function getByName(string $firstname, string $lastname): array
    {
        $qb = $this->createQueryBuilder('c');
        $qb
            ->where('c.firstname = :firstname')
            ->andWhere('c.lastname = :lastname')
            ->setParameter('firstname', $firstname)
            ->setParameter('lastname', $lastname)
            ->orderBy('c.createdAt');

        return $qb->getQuery()->getArrayResult();
    }
}
