<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class AppFixtures
 * @package App\DataFixtures
 */
class AppFixtures extends Fixture
{
    /**
     * Insert 20 rows to table Contacts
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $product = new Contact();
            $product
                ->setFirstname('firstname_' . $i)
                ->setLastname('lastname_' . $i)
                ->setAddressInformation('address_' . $i)
                ->setUpdatedAt(new \DateTime())
                ->setCreatedAt(new \DateTime());
            $manager->persist($product);
        }
        $manager->flush();
    }
}
