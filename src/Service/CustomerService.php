<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Contact;
use App\Entity\Customer;
use App\Repository\CustomerRepository;

/**
 * Class CustomerService
 * @package App\Service
 */
class CustomerService
{
    /** @var CustomerRepository */
    protected CustomerRepository $customerRepository;

    /**
     * @param CustomerRepository $customerRepository
     */
    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * Find contact by Id
     *
     * @param int $id
     * @return Customer|null
     */
    public function findById(int $id): ?Customer
    {
        return $this->customerRepository->find($id);
    }

    /**
     * Add other customers as contact
     *
     * @param Customer $customer
     * @return Contact
     */
    public function setCustomerAsContact(Customer $customer): Contact
    {
        $contact = new Contact();
        $contact
            ->setFirstname($customer->getFirstname())
            ->setLastname($customer->getLastname())
            ->setAddressInformation($customer->getAddressInformation())
            ->setPhoneNumber($customer->getPhoneNumber())
            ->setBirthday($customer->getBirthday())
            ->setEmailAddress($customer->getEmailAddress())
            ->setPicture($customer->getPicture())
            ->setFkCustomerId($customer);
        $this->customerRepository->persistEntity($contact);
        $this->customerRepository->flushEntity();

        return $contact;
    }
}
