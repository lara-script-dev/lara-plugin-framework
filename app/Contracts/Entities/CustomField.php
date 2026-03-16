<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Entities;

interface CustomField
{
    public function getId(): int;

    /**
     * Machine-readable key of the field, e.g. "card_number".
     */
    public function getKey(): string;

    /**
     * Human-readable name; may be localized on consumer side.
     */
    public function getName(): string;

    /**
     * Input type identifier.
     * Known values: "nickname", "input", "number", "textarea", "select",
     * "boolean", "date", "email", "phone", "city_select", "custom_selector".
     */
    public function getType(): string;

    /**
     * Optional placeholder text.
     */
    public function getPlaceholder(): ?string;

    /**
     * Optional help/description text.
     */
    public function getHelp(): ?string;

    /**
     * Whether the field is active (available for use).
     */
    public function isActive(): bool;

    /**
     * Whether the field is required.
     */
    public function isRequired(): bool;

    /**
     * Додаткові атрибути/налаштування поля залежно від `type`.
     * Повертає асоціативний масив або null, якщо атрибутів немає.
     *
     * Підтримувані схеми (за даними exchanger-core):
     * - type="input":
     *   {allowed_symbols: string, drop_spaces: bool, min_length: int, max_length: int}
     *   Приклад: {"allowed_symbols":"all","drop_spaces":false,"min_length":0,"max_length":1000}
     *
     * - type="number":
     *   {min: int, max: int}
     *   Приклад: {"min":0,"max":1000}
     *
     * - type="textarea":
     *   {min_length: int, max_length: int}
     *   Приклад: {"min_length":0,"max_length":1000}
     *
     * - type="select":
     *   {options: list<string|array{label:string,value:string}>|string(json), default_option: int}
     *   Примітка: options може бути масивом або JSON-рядком; елементи можуть бути простими рядками або об’єктами
     *   з ключами label/value. Приклад: {"options":["Option 1","Option 2"],"default_option":0}
     *
     * - type="boolean":
     *   {default_boolean: bool}
     *   Приклад: {"default_boolean":false}
     *
     * - type="date":
     *   {date_format: string|null}
     *   Приклад: {"date_format":"Y-m-d"}
     *
     * - type="city_select":
     *   {coefficient: string}
     *   Приклад: {"coefficient":"1.0"}
     *
     * - type="custom_selector":
     *   {options: list<array{id?: string, label: string|array<string,string>, coefficient: int|float|string}>|string(json)}
     *   Примітки: label може бути рядком або мапою локалі=>текст; id може бути відсутній (генерується на боці сервісу).
     *   Приклад: {"options":[{"id":"1","label":{"en":"Fast","uk":"Швидко"},"coefficient":1.0}]}
     *
     * @return array<string, mixed>|null
     */
    public function getAttributes(): ?array;
}
