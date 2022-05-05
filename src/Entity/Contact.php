<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use App\Traits\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
#[ORM\Table(name: '`contact`')]
#[ApiResource]
class Contact
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "IDENTITY")]
    #[ORM\Column(name: 'id', type: 'integer')]
    private $id;

    #[ORM\Column(name: 'firstname', type: 'string', length: 255, nullable: false)]
    #[Assert\NotBlank]
    private $firstname;

    #[ORM\Column(name: 'lastname', type: 'string', length: 255, nullable: false)]
    #[Assert\NotBlank]
    private $lastname;

    #[ORM\Column(name: 'address_information', type: 'string', length: 500, nullable: false)]
    #[Assert\NotBlank]
    private $addressInformation;

    #[ORM\Column(name: 'phone_number', type: 'string', length: 20, nullable: false)]
    #[Assert\NotBlank]
    private $phoneNumber;

    #[ORM\Column(name: 'birthday', type: 'date', nullable: false)]
    #[Assert\NotBlank]
    private $birthday;

    #[ORM\Column(name: 'email_address', type: 'string', length: 255, nullable: false)]
    #[Assert\NotBlank]
    private $emailAddress;

    #[ORM\Column(name: 'picture', type: 'string', length: 255, nullable: true)]
    private $picture;

    #[ORM\ManyToOne(targetEntity: "App\Entity\Customer")]
    #[ORM\JoinColumn(name: "fk_customer_id", referencedColumnName: "id", nullable: true)]
    private $fkCustomerId;

    public function __construct()
    {
        $this->updatedAt = new \DateTime();
        $this->createdAt = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return $this
     */
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     * @return $this
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddressInformation(): string
    {
        return $this->addressInformation;
    }

    /**
     * @param string $addressInformation
     * @return $this
     */
    public function setAddressInformation(string $addressInformation): self
    {
        $this->addressInformation = $addressInformation;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     * @return $this
     */
    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getBirthday(): \DateTime
    {
        return $this->birthday;
    }

    /**
     * @param \DateTime $birthday
     * @return $this
     */
    public function setBirthday(\DateTime $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmailAddress(): string
    {
        return $this->emailAddress;
    }

    /**
     * @param string $emailAddress
     * @return $this
     */
    public function setEmailAddress(string $emailAddress): self
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    /**
     * @return string
     */
    public function getPicture(): string
    {
        return $this->picture;
    }

    /**
     * @param string $picture
     * @return $this
     */
    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return Customer
     */
    public function getFkCustomerId(): Customer
    {
        return $this->fkCustomerId;
    }

    /**
     * @param Customer $fkCustomerId
     * @return $this
     */
    public function setFkCustomerId(Customer $fkCustomerId): self
    {
        $this->fkCustomerId = $fkCustomerId;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }

}
