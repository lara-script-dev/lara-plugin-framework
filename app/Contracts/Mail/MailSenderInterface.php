<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Mail;

interface MailSenderInterface
{
    public function send(string $recipient, string $subject, string $html): bool;

    /** @param array<string, scalar|null> $variables */
    public function sendTemplate(
        string $recipient,
        string $template,
        string $languageCode,
        array $variables,
    ): bool;
}
