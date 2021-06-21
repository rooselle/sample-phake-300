<?php

namespace App\Tests\Mailer;

use App\Mailer\ContactEmailFactory;
use App\Mailer\ContactMailer;
use Phake;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\MailerInterface;

final class ContactMailerTest extends TestCase
{
    private MailerInterface $mailer;
    private ContactEmailFactory $factory;
    private ContactMailer $contactMailer;
    private TemplatedEmail $email;

    protected function setUp(): void
    {
        $this->mailer = Phake::mock(MailerInterface::class);
        $this->factory = Phake::mock(ContactEmailFactory::class);
        $this->email = Phake::mock(TemplatedEmail::class);

        Phake::when($this->factory)->createEmail()->thenReturn($this->email);

        $this->contactMailer = new ContactMailer($this->mailer, $this->factory);
    }

    public function testSendEmail(): void
    {
        $this->contactMailer->sendEmail();

        Phake::verify($this->factory)->createEmail();
        Phake::verify($this->mailer)->send($this->email);
        $this->assertTrue($this->contactMailer->hadSuccess);
    }

    public function testSendEmailException(): void
    {
        Phake::when($this->mailer)->send($this->email)->thenThrow(new TransportException('A transport exception has occured !'));

        $this->contactMailer->sendEmail();

        $this->assertFalse($this->contactMailer->hadSuccess);
    }
}
