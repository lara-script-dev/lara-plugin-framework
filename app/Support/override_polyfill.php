<?php

declare(strict_types=1);

namespace {
    if (!class_exists('Override')) {
        #[\Attribute(\Attribute::TARGET_METHOD)]
        final class Override {}
    }
}

