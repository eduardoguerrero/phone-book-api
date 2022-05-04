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
    public function __toString(): string
    {
        return $this->firstname;
    }


}
