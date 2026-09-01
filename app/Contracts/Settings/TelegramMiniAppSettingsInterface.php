<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Settings;

/**
 * Credentials the host verifies Telegram Mini App logins against. A plugin that stores
 * them binds its own implementation over the host's.
 */
interface TelegramMiniAppSettingsInterface
{
    public function isEnabled(): bool;

    /**
     * Plain text, empty when unset - implementations decrypt here.
     */
    public function getBotToken(): string;

    public function hasBotToken(): bool;

    /**
     * Without the leading `@`.
     */
    public function getBotUsername(): string;

    /**
     * Seconds an initData payload stays acceptable after its `auth_date`. Never 0, which
     * would expire every payload on arrival.
     */
    public function getAuthDateTtl(): int;
}
