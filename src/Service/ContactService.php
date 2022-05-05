<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Contact;
use App\Repository\ContactRepository;

/**
 * Class ContactService
 * @package App\Service
 */
class ContactService
{
    /** @var ContactRepository */
    protected ContactRepository $contactRepository;

    /**
     * @param ContactRepository $contactRepository
     */
    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    /**
     * Get all contacts
     *
     * @return Contact[]
     */
    public function getAll(): array
    {
        return $this->contactRepository->findAll();
    }

    /**
     * Find contact by Id
     *
     * @param int $id
     * @return Contact|null
     */
    public function findById(int $id): ?Contact
    {
        return $this->contactRepository->find($id);
    }

    /**
     * Delete contact
     *
     * @param Contact $contact
     * @return void
     */
    public function remove(Contact $contact): void
    {
        $this->contactRepository->removeEntity($contact);
        $this->contactRepository->flushEntity();
    }

    /**
     * Get contact taking into account firstname and lastname
     *
     * @param string $firstname
     * @param string $lastname
     * @return array
     */
    public function getByName(string $firstname, string $lastname): array
    {
        return $this->contactRepository->getByName($firstname, $lastname);
    }

    /**
     * Edit a contact
     *
     * @param Contact $contact
     * @param array $content
     * @return Contact
     * @throws \Exception
     */
    public function edit(Contact $contact, array $content): Contact
    {
        if (!filter_var($content['email_address'], FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email');
        }
        $contact
            ->setFirstname($content['firstname'])
            ->setLastname($content['lastname'])
            ->setAddressInformation($content['address_information'])
            ->setPhoneNumber($content['phone_number'])
            ->setBirthday(new \DateTime($content['birthday']))
            ->setEmailAddress($content['email_address'])
            ->setPicture($content['picture']);
        $this->contactRepository->persistEntity($contact);
        $this->contactRepository->flushEntity();

        return $contact;
    }
}
