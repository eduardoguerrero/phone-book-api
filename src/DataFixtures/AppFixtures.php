<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class AppFixtures
 * @package App\DataFixtures
 */
class AppFixtures extends Fixture
{
    /**
     * Insert rows to table 'Contacts'
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $costumer = new Customer();
            $costumer
                ->setFirstname('firstname_' . $i)
                ->setLastname('lastname_' . $i)
                ->setAddressInformation('address_' . $i)
                ->setPhoneNumber('+50373953277' . $i)
                ->setBirthday(new \DateTime())
                ->setEmailAddress('email_' . $i . '@gmail.com')
                ->setPicture('picture_' . $i . '.jpg')
                ->setLastlogin(new \DateTime())
                ->setGender('F')
                ->setSubscribedToNewsletter(1)
                ->setIsActive(1)
                ->setUpdatedAt(new \DateTime())
                ->setCreatedAt(new \DateTime());
            $manager->persist($costumer);

            $contact = new Contact();
            $contact
                ->setFirstname('firstname_' . $i)
                ->setLastname('lastname_' . $i)
                ->setAddressInformation('address_' . $i)
                ->setPhoneNumber('+50373953277' . $i)
                ->setBirthday(new \DateTime())
                ->setEmailAddress('email_' . $i . '@gmail.com')
                ->setPicture('picture_' . $i . '.jpg')
                ->setFkCustomerId($costumer)
                ->setUpdatedAt(new \DateTime())
                ->setCreatedAt(new \DateTime());
            $manager->persist($contact);
        }
        $manager->flush();
    }
}
