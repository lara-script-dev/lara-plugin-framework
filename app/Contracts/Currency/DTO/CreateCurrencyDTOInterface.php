<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Currency\DTO;

interface CreateCurrencyDTOInterface
{
    /**
     * Currency shorthand (ticker), e.g. "BTC", "USDt".
     */
    public function getShorthand(): string;

    /**
     * Default available amount/stock for currency as a decimal string.
     * Use dot as decimal separator, e.g. "1000.00000000". Null to omit.
     */
    public function getAmount(): ?string;

    /**
     * Minimal amount in USD equivalent as a decimal string.
     * Use dot as decimal separator. Null to omit.
     */
    public function getMinAmountUsd(): ?string;

    /**
     * Minimal input amount for directions where this currency is used as FROM.
     * Decimal string; dot as decimal separator. Null to omit.
     */
    public function getFromMinAmount(): ?string;

    /**
     * Minimal output amount for directions where this currency is used as TO.
     * Decimal string; dot as decimal separator. Null to omit.
     */
    public function getToMinAmount(): ?string;

    /**
     * Maximal allowed amount as a decimal string.
     * Dot as decimal separator. Null to omit.
     */
    public function getMaxAmount(): ?string;

    /**
     * Merchant/provider identifier (slug or code) responsible for processing.
     */
    public function getMerchant(): string;

    /**
     * Display/rounding precision for this currency (number of fraction digits).
     */
    public function getPrecision(): int;

    /**
     * Related category IDs for this currency.
     *
     * @return list<int> List of category identifiers.
     */
    public function getCategoryIds(): array;

    /**
     * Optional icon file/storage ID.
     */
    public function getIconId(): ?int;

    /**
     * Base currency code for quoting, e.g. "USD".
     */
    public function getBaseCurrency(): string;

    /**
     * Merchant-specific ticker, if differs from public shorthand.
     */
    public function getMerchantTicker(): ?string;

    /**
     * Merchant-specific network identifier, e.g. "ERC20", "TRC20".
     */
    public function getMerchantNetwork(): ?string;

    /**
     * Quote ID representing USD pair used for conversions.
     * Null to omit.
     */
    public function getUsdQuoteId(): ?int;

    /**
     * Required blockchain confirmations for considering transaction final.
     */
    public function getConfirmationsCount(): int;

    /**
     * Alternate shorthand for exports/integrations, if needed.
     */
    public function getExportShorthand(): ?string;

    /**
     * Indicates bulk editing context; implementations may relax validations.
     */
    public function isBulkEditing(): ?bool;

    /**
     * Whether to show transaction hash input for this currency.
     */
    public function isTxHashInputShown(): ?bool;

    /**
     * Whether requisite (KYC) verification is required when using this currency.
     */
    public function isRequisiteVerificationRequired(): ?bool;

    /**
     * Max allowed payout period in hours. Null to omit.
     */
    public function getMaxPayoutPeriodH(): ?int;

    /**
     * USD threshold from which social details become required (decimal string).
     */
    public function getSocialRequiredFromAmountUsd(): ?string;

    /**
     * Localized currency names by locale code.
     *
     * Example: {"en": "Tether USD", "uk": "Тетер"}
     * @return array<string,string>|null Map of locale => name, or null.
     */
    public function getName(): ?array;

    /**
     * Localized Telegram annotations by locale code.
     *
     * @return array<string,string>|null Map of locale => text, or null.
     */
    public function getTelegramAnnotation(): ?array;

    /**
     * Localized annotations shown on the FROM side.
     *
     * @return array<string,string>|null Map of locale => text, or null.
     */
    public function getAnnotationFrom(): ?array;

    /**
     * Localized annotations shown on the TO side.
     *
     * @return array<string,string>|null Map of locale => text, or null.
     */
    public function getAnnotationTo(): ?array;

    /**
     * Localized merchant description texts.
     *
     * @return array<string,string>|null Map of locale => text, or null.
     */
    public function getMerchantDescription(): ?array;

    /**
     * Mapping of currency custom fields to attach.
     * Each item is an associative array with keys:
     * - id: int (custom field ID)
     * - direction: "from"|"to"
     * - order?: int|null (optional display/processing order)
     * - is_main_requisite?: bool (optional; default false)
     *
     * @return list<array{id:int, direction: string, order?: int|null, is_main_requisite?: bool}>|null
     */
    public function getCustomFields(): ?array;
}
