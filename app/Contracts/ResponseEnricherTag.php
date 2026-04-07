<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts;

/**
 * Service container tags for response enrichers.
 *
 * Plugins register their enricher implementations under these tags.
 * The core collects all tagged enrichers per context (public/admin)
 * and delegates to them during response serialization.
 *
 * Public enrichers run in web API Resources (end-user facing).
 * Admin enrichers run in admin JSON:API Transformers (admin panel).
 */
final class ResponseEnricherTag
{
    public const PUBLIC_ORDER = 'public_order_response_enrichers';
    public const ADMIN_ORDER = 'admin_order_response_enrichers';
    public const PUBLIC_DIRECTION = 'public_direction_response_enrichers';
    public const ADMIN_DIRECTION = 'admin_direction_response_enrichers';
}
