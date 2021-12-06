<?php


namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class EmailService
{

    private MailerInterface $mailer;

    /**
     * EmailService constructor.
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendMail(string $senderEmailAddress, string $receiverEmailAddress, string $subject, string $template, array $context): void
    {
        $email = (new TemplatedEmail())
            ->from($senderEmailAddress)
            ->to($receiverEmailAddress)
            ->subject($subject)
            ->htmlTemplate($template)
            ->context($context);

        $this->mailer->send($email);
    }
}
