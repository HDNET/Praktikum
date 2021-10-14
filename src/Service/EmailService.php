<?php


namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
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

    public function sendMail(string $receiverEmailAddress, string $subject, array $context): void
    {
        $email = (new TemplatedEmail())
            ->from('configuration@YourBikeHD.com')
            ->to($receiverEmailAddress)
            ->subject($subject)
            ->htmlTemplate('emails/submitConfiguration.html.twig')
            ->context($context);

        $this->mailer->send($email);
    }
}