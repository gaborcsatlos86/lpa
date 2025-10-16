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
    
    public function sendMail(string $from, string $to, string $subject, string $content, array $cc = []): bool
    {
        $email = (new Email())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->html($content)
        ;
        
        foreach ($cc as $ccAddress) {
            $email = $email->addCc($ccAddress);
        }
        try {
            $this->mailer->send($email);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }
}