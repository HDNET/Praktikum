<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    /**
     * Make sure the name field is not empty
     * @Assert\NotBlank
     */
    protected string $name = '';
    /**
     * Make sure the email field is a valid email address and is not empty
     * @Assert\NotBlank
     * @Assert\Email
     */
    protected string $email = '';
    /**
     * Make sure the subject field is not empty
     * @Assert\NotBlank
     */
    protected string $subject = '';
    /**
     * Make sure the message field is not empty
     * @Assert\NotBlank
     */
    protected string $message = '';

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}
