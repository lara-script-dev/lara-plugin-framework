<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts;

/**
 * Service container tags for order interceptors.
 *
 * Plugins register their interceptor implementations under these tags.
 * The core collects all tagged interceptors and delegates to them
 * during order creation and recalculation.
 */
final class InterceptorTag
{
    public const ORDER_CREATION = 'order_creation_interceptors';
    public const ORDER_CREATION_RULES = 'order_creation_rule_providers';
    public const ORDER_RECALCULATION = 'order_recalculation_interceptors';
}
