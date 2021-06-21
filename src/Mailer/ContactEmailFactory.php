<?php

namespace App\Mailer;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Contracts\Translation\TranslatorInterface;

class ContactEmailFactory
{
    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function createEmail(): TemplatedEmail
    {
        return (new TemplatedEmail())
            ->from('foo@example.com')
            ->to('bar@example.com')
            ->replyTo('baz@example.com')
            ->subject($this->translator->trans('phake.email.subject'))
            ->text($this->translator->trans('phake.email.text'));
    }
}
