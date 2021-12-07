<?php


namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class EmailService
{

    /**
     * In the emailInterface $email will be the mailer to send the mails
     * @var MailerInterface
     */
    private MailerInterface $mailer;

    /**
     * EmailService constructor.
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param string $senderEmailAddress
     * @param string $receiverEmailAddress
     * @param string $subject
     * @param string $template
     * @param array $context
     * @throws TransportExceptionInterface
     */
    public function sendMail(string $senderEmailAddress, string $receiverEmailAddress, string $subject, string $template, array $context): void
    {
        // create a new email as an email which will be rendered from a template
        $email = (new TemplatedEmail())
            ->from($senderEmailAddress) // set the sender of the email
            ->to($receiverEmailAddress) // set the receiver of the Email
            ->subject($subject) // set the subject of the Email
            ->htmlTemplate($template) // set the template name which should be used to render the email
            ->context($context); // set the additional context

        // send the mail
        $this->mailer->send($email);
    }
}
