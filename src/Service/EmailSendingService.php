<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use \Exception;

class EmailSendingService
{
    public function __construct(
        private MailerInterface $mailer
    ){}
    
    public function sendMail(string $from, string $to, string $subject, string $content): bool
    {
        $email = (new Email())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->html($content)
        ;
        try {
            $this->mailer->send($email);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }
}