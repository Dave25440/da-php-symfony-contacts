<?php

namespace App\Model;

class Contact
{
    public function __construct(
        private ?int $id = null,
        private ?string $name = null,
        private ?string $email = null,
        private ?string $phoneNumber = null
    ) {}

    public function getId() : ?int
    {
        return $this->id;
    }

    public function getName() : ?string
    {
        return $this->name;
    }

    public function getEmail() : ?string
    {
        return $this->email;
    }

    public function getPhoneNumber() : ?string
    {
        return $this->phoneNumber;
    }

    public function setId(?int $id) : void
    {
        $this->id = $id;
    }

    public function setName(?string $name) : void
    {
        $this->name = $name;
    }

    public function setEmail(?string $email) : void
    {
        $this->email = $email;
    }

    public function setPhoneNumber(?string $phoneNumber) : void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function __toString() : string
    {
        return sprintf(
            "Contact #%s : %s, Email : %s, Téléphone : %s",
            $this->id ?? 'N/A',
            $this->name ?? 'N/A',
            $this->email ?? 'N/A',
            $this->phoneNumber ?? 'N/A'
        );
    }
}
