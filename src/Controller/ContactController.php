<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\ContactService;
use App\Service\CustomerService;
use Doctrine\DBAL\Driver\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use App\Entity\Contact;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('api/contacts')]
final class ContactController extends ApiController
{
    /** @var ContactService */
    protected ContactService $contactService;

    /** @var CustomerService */
    protected CustomerService $customerService;

    /**
     * @param ContactService $contactService
     * @param CustomerService $customerService
     */
    public function __construct(ContactService $contactService, CustomerService $customerService)
    {
        $this->contactService = $contactService;
        $this->customerService = $customerService;
    }

    /**
     * List all contacts.
     *
     * This call returns all contacts.
     *
     * @Route("", methods={"GET"})
     * @OA\Response(
     *     response=200,
     *     description="Returns contact list",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Contact::class, groups={"full"}))
     *     )
     * )
     * @OA\Tag(name="contact")
     * @Security(name="Bearer")
     */
    public function getAll()
    {
        return $this->json($this->contactService->getAll());
    }

    /**
     * Delete existing contact.
     *
     * This call removes a contact, use a contact ID in order to identify the row to delete.
     *
     * @Route("/{contactId}", methods={"DELETE"})
     * @OA\Response(
     *     response=200,
     *     description="Returns the message 'Contact deleted'",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Contact::class, groups={"full"}))
     *     )
     * )
     * @OA\Response(
     *     response=404,
     *     description="Returns the message 'Contact not found' or 'Contact error'",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Contact::class, groups={"full"}))
     *     )
     * )
     *
     * @OA\Tag(name="contact")
     * @Security(name="Bearer")
     */
    public function delete(int $contactId): JsonResponse
    {
        $contact = $this->contactService->findById($contactId);
        if (!$contact) {
            return $this->json(['Contact not found'], Response::HTTP_NOT_FOUND);
        }
        try {
            $this->contactService->remove($contact);
        } catch (\Exception $e) {
            return $this->json(['Contact error' => $e->getMessage()]);
        }

        return $this->json(['Contact deleted']);
    }

    /**
     * Search for contact by name
     *
     * This call search for contact by name.
     *
     * @Route("/by-name/{firstname}/{lastname}", methods={"GET"})
     * @OA\Response(
     *     response=200,
     *     description="Returns the contact by name",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Contact::class, groups={"full"}))
     *     )
     * )
     * @OA\Response(
     *     response=404,
     *     description="Returns the message 'Contact not found'",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Contact::class, groups={"full"}))
     *     )
     * )
     *
     * @OA\Tag(name="contact")
     * @Security(name="Bearer")
     */
    public function getByName(string $firstname, string $lastname): JsonResponse
    {
        $contact = $this->contactService->getByName($firstname, $lastname);
        if (!$contact) {
            return $this->json(['Contact not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($contact);
    }

    /**
     * Edit created contacts.
     *
     * This call allows you to edit created contacts, request example:
     *
     *    {
     *       "firstname": "Rene",
     *       "lastname": "lastname",
     *       "address_information": "Santa Clara SV",
     *       "phone_number": "244-24461",
     *       "birthday": "1986-03-29",
     *       "email_address": "escobarguerrero@gmail.com",
     *       "picture": "data:image/png;base64,AAAFBfj42Pj4"
     *    }
     *
     *
     *
     * @Route("/{contactId}", methods={"PATCH"})
     * @OA\Response(
     *     response=200,
     *     description="Returns the message 'Contact edited'",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Contact::class, groups={"full"}))
     *     )
     * )
     * @OA\Response(
     *     response=404,
     *     description="Returns the message 'Contact not found' or 'Contact error'",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Contact::class, groups={"full"}))
     *     )
     * )
     *
     * @OA\Tag(name="contact")
     * @Security(name="Bearer")
     */
    public function edit(int $contactId, Request $request, ValidatorInterface $validator)
    {
        $contact = $this->contactService->findById($contactId);
        if (!$contact) {
            return $this->json(['Contact not found'], Response::HTTP_NOT_FOUND);
        }
        try {
            $content = $this->getHttpBodyData($request);
            $response = $this->contactService->edit($contact, $content);
        } catch (\Exception $e) {
            return $this->json(['Contact error' => $e->getMessage()]);
        }

        return $this->json(['Contact updated' => $response->getId()]);
    }

    /**
     * Add other customers as contact
     *
     * This call allows you to add other customers as contact, you can associate a existing customer as a contact with
     * other customer.     *
     * ownerCustomerId: It will be the owner of the new contact and customerId: It will be the new contact
     *
     * @Route("/customer/{ownerCustomerId}/contact/{customerId}", methods={"POST"})
     * @OA\Response(
     *     response=200,
     *     description="Returns the message 'Contact created'",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Contact::class, groups={"full"}))
     *     )
     * )
     * @OA\Response(
     *     response=404,
     *     description="Returns the message 'Contact not found' or 'Contact error'",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Contact::class, groups={"full"}))
     *     )
     * )
     *
     * @OA\Tag(name="contact")
     * @Security(name="Bearer")
     */
    public function add(int $ownerCustomerId, int $customerId)
    {
        // Avoid save same customer as a contact
        if ($ownerCustomerId === $customerId) {
            return $this->json(['The new contact must be different to the customer that makes the action'], Response::HTTP_NOT_FOUND);
        }
        // Seek to the customer that will be a contact
        $customer = $this->customerService->findById($customerId);
        if (!$customer) {
            return $this->json(['Contact not found'], Response::HTTP_NOT_FOUND);
        }
        try {
            $contact = $this->customerService->setCustomerAsContact($customer);
        } catch (Exception $e) {
            return $this->json(['Contact error' => $e->getMessage()]);
        }

        return $this->json(['Contact created' => $contact->getId(), Response::HTTP_CREATED]);
    }
}
