<?php

namespace App\Tests\Mailer;

use App\Mailer\ContactEmailFactory;
use Phake;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\Translation\TranslatorInterface;

final class EmailFactoryTest extends TestCase
{
    public function testCreateEmail(): void
    {
        $translator = Phake::mock(TranslatorInterface::class);

        Phake::when($translator)->trans('phake.email.subject')->thenReturn('A great subject');
        Phake::when($translator)->trans('phake.email.text')->thenReturn('An awesome text');

        $factory = new ContactEmailFactory($translator);
        $email = $factory->createEmail();

        $this->assertEquals('A great subject', $email->getSubject());
        $this->assertEquals('An awesome text', $email->getTextBody());
    }
}
