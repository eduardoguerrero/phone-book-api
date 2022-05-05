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
class ContactRepository extends AbstractServiceEntityRepository implements ContactInterface
{
    // Set entity class to ServiceEntityRepository parent
    protected string $entityClass = Contact::class;

    /**
     * Get contact taking into account firstname and lastname
     *
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
            ->setParameter('lastname', $lastname);

        return $qb->getQuery()->getArrayResult();
    }

}
