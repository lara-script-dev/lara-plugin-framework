<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Merchant;

use LaraPluginFramework\Contracts\Entities\Currency;
use LaraPluginFramework\Contracts\Entities\Decimal;
use LaraPluginFramework\Contracts\Entities\Direction;
use LaraPluginFramework\Contracts\Entities\Wallet;
use LaraPluginFramework\Contracts\Context\Context;
use LaraPluginFramework\Contracts\Result\ResultInterface;
use Illuminate\Http\Request;

interface MerchantInterface
{
    public function getAddress(): ?Wallet;

    public function getCurrency(): Currency;

    public function getDirection(): ?Direction;

    public function getInAmount(): ?Decimal;

    public function setCurrency(Currency $currency): void;

    public function setDirection(Direction $direction): void;

    public function setInAmount(?Decimal $inAmount): void;

    public function createNotification(): void;

    public function deleteNotification(): void;

    public function handleNotification(Context $context): ResultInterface;

    public function checkRequest(Request $request): ResultInterface;
}
