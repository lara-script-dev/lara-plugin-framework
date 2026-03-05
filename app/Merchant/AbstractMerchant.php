<?php

declare(strict_types=1);

namespace LaraPluginFramework\Merchant;

use LaraPluginFramework\Contracts\Entities\Currency;
use LaraPluginFramework\Contracts\Entities\Decimal;
use LaraPluginFramework\Contracts\Entities\Direction;
use LaraPluginFramework\Contracts\Merchant\MerchantInterface;
use LaraPluginFramework\Contracts\Context\Context;
use LaraPluginFramework\Contracts\Result\ResultInterface;

abstract class AbstractMerchant implements MerchantInterface
{
    private Currency $currency;
    private ?Decimal $inAmount = null;
    private ?Direction $direction = null;

    #[\Override]
    public function setCurrency(Currency $currency): void
    {
        $this->currency = $currency;
    }

    #[\Override]
    public function setDirection(Direction $direction): void
    {
        $this->direction = $direction;
    }

    #[\Override]
    public function setInAmount(?Decimal $inAmount): void
    {
        $this->inAmount = $inAmount;
    }

    #[\Override]
    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    #[\Override]
    public function getDirection(): ?Direction
    {
        return $this->direction;
    }

    #[\Override]
    public function getInAmount(): ?Decimal
    {
        return $this->inAmount;
    }

    #[\Override]
    public function createNotification(): void
    {
    }

    #[\Override]
    public function deleteNotification(): void
    {
    }

    #[\Override]
    abstract public function handleNotification(Context $context): ResultInterface;
}
