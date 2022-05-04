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
    public const API_MESSAGES = [
        'not_found' => ['Contact not found'],
        'deleted' => ['Contact deleted'],
    ];


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
     * @return Contact[]
     */
    public function getAll(): array
    {
        return $this->contactRepository->findAll();
    }

    /**
     * @param int $id
     * @return Contact|null
     */
    public function findById(int $id): ?Contact
    {
        return $this->contactRepository->find($id);
    }

    /**
     * @param Contact $contact
     * @return void
     */
    public function remove(Contact $contact): void
    {
        $this->contactRepository->removeEntity($contact);
        $this->contactRepository->flushEntity();
    }

    /**
     * @param string $firstname
     * @param string $lastname
     * @return array
     */
    public function getByName(string $firstname, string $lastname): array
    {
        return $this->contactRepository->getByName($firstname, $lastname);
    }
}
