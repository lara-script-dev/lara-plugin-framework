<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Direction\DTO;

interface CreateDirectionDTOInterface
{
    /**
     * Source currency ID.
     */
    public function getFromId(): int;

    /**
     * Target currency ID.
     */
    public function getToId(): int;

    /**
     * Quote (pair) ID used for pricing this direction.
     */
    public function getQuoteId(): int;

    /**
     * Exchange percent (fee or markup) as a decimal string.
     * Use dot as decimal separator, e.g. "0.5" for 0.5%.
     */
    public function getPercent(): string;

    /**
     * Direction priority; higher values may be ranked first.
     */
    public function getPriority(): int;

    /**
     * Whether the direction is enabled. Null keeps current/default.
     */
    public function isEnabled(): ?bool;

    /**
     * Precision for FROM currency amounts (fraction digits). Null to omit.
     */
    public function getFromPrecision(): ?int;

    /**
     * Precision for TO currency amounts (fraction digits). Null to omit.
     */
    public function getToPrecision(): ?int;

    /**
     * Minimal allowed input amount as a decimal string. Null to omit.
     */
    public function getMinAmount(): ?string;

    /**
     * Maximal allowed input amount as a decimal string. Null to omit.
     */
    public function getMaxAmount(): ?string;

    /**
     * Profit percent as a decimal string; dot as decimal separator.
     */
    public function getProfitPercent(): string;

    /**
     * Whether user verification (KYC) is required for this direction.
     */
    public function isUserVerificationRequired(): ?bool;

    /**
     * Indicates bulk editing context; implementations may relax validations.
     */
    public function isBulkEditing(): ?bool;

    /**
     * Whether automatic sell is disabled for this direction.
     */
    public function isAutoSellDisabled(): ?bool;

    /**
     * Merchant/provider identifier (slug or code) that serves this direction.
     */
    public function getMerchant(): string;

    /**
     * Force direction to be processed as automatic if supported.
     */
    public function isForcedAsAuto(): ?bool;

    /**
     * Allowed cities (scope restriction).
     *
     * Supports two forms:
     * - list<int> — simple list of city IDs.
     * - list<array{id:int, coefficient:string, min_amount?:string, max_amount?:string}> —
     *   detailed per-city configuration. Decimal values use dot separator and must be strings.
     *
     * Implementations may provide either form; consumers should normalize values.
     *
     * @return (list<int>|list<array{
     *     id: int,
     *     coefficient: string,
     *     min_amount?: string,
     *     max_amount?: string
     * }>)|null
     */
    public function getCities(): ?array;

    /**
     * Auto-withdraw providers supported by this direction.
     *
     * Supports two forms:
     * - list<string> — list of provider codes.
     * - list<array{code:string, min_amount?:string, max_amount?:string}> —
     *   provider codes with optional per-direction min/max limits (decimal strings).
     *
     * Implementations may provide either form; consumers should resolve codes via
     * a repository and normalize min/max (fallback to provider defaults when omitted).
     *
     * @return (list<string>|list<array{
     *     code: string,
     *     min_amount?: string,
     *     max_amount?: string
     * }>)|null
     */
    public function getAutoWithdrawIntegrations(): ?array;

    /**
     * Lower export visibility boundary as ISO-8601 datetime string. Null to omit.
     */
    public function getExportNotVisibleFrom(): ?string;

    /**
     * Upper export visibility boundary as ISO-8601 datetime string. Null to omit.
     */
    public function getExportNotVisibleTo(): ?string;
}
