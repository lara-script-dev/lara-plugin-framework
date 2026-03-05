<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Result;

use Illuminate\Http\Response;

interface ResultInterface
{
    public function isSuccessful(): bool;

    public function getErrorMessage(): string;

    /**
     * @param array<string, string> $headers
     */
    public function withResponse(int $code, string $content, array $headers = []): self;

    public function getResponse(): ?Response;
}
