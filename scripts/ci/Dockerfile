# CI only: the official CLI image for the matrix PHP version plus what Composer needs (git for
# VCS sources, unzip for dist archives) and the Composer binary from its official image. Every
# base is pinned by digest; PHP_VERSION picks the stage (declared before the first FROM so it
# is visible to every FROM).
ARG PHP_VERSION
FROM php:8.2-cli@sha256:118ef4fb1db5e866fb604f2f260da81f819a0a1eac87a4083f9194f48e00beee AS php-8.2
FROM php:8.3-cli@sha256:aafe21201943a8a6e497ddfb471e2ce68ada76adede38c7d61fede8918b24319 AS php-8.3
FROM php:8.4-cli@sha256:d63e8b80cd4c6cfd01cfa7c910522e299cdc7ca1a2b6d6563db48df3c17e6c55 AS php-8.4

FROM php-${PHP_VERSION}

RUN apt-get update \
    && apt-get install -y --no-install-recommends git unzip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2@sha256:af98f42dfff7c68ba8d53c2164fd9fde1087b7d449514baa38c418b1f6bc4bac /usr/bin/composer /usr/bin/composer
