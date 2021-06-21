<?php

namespace App\Mailer;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactMailer
{
    private MailerInterface $mailer;
    private ContactEmailFactory $factory;

    public bool $hadSuccess;

    public function __construct(MailerInterface $mailer, ContactEmailFactory $factory)
    {
        $this->mailer = $mailer;
        $this->factory = $factory;
    }

    public function sendEmail(): void
    {
        $email = $this->factory->createEmail();
        $this->dispatch($email);
    }

    private function dispatch(Email $email): void
    {
        try {
            $this->mailer->send($email);
            $this->hadSuccess = true;
        } catch (TransportExceptionInterface $exception) {
            $this->hadSuccess = false;
        }
    }
}
