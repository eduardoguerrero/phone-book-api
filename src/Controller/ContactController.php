<?php

namespace App\Controller;

use App\Service\ContactService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use App\Entity\Contact;

#[Route('api/contacts')]
final class ContactController extends AbstractController
{
    /** @var ContactService */
    protected ContactService $contactService;

    /**
     * @param ContactService $contactService
     */
    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    /**
     * List all contacts.
     *
     * This call returns all contacts..
     *
     * @Route("/", methods={"GET"})
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
     * @Route("/{id}", methods={"DELETE"})
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
    public function delete(int $id): JsonResponse
    {
        $contact = $this->contactService->findById($id);
        if (!$contact) {
            return $this->json(ContactService::API_MESSAGES['not_found'], Response::HTTP_NOT_FOUND);
        }
        $this->contactService->remove($contact);

        return $this->json(ContactService::API_MESSAGES['deleted']);
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
            return $this->json(ContactService::API_MESSAGES['not_found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($contact);
    }


}
