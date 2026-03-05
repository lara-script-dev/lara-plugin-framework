<?php

declare(strict_types=1);

namespace LaraPluginFramework\Fields;

use LaraPluginFramework\Enums\InputTypeEnum;

final class FieldBuilder
{
    private InputTypeEnum $type = InputTypeEnum::TEXT;
    private string $label = '';
    private bool $required = false;
    private ?string $placeholder = null;
    private ?string $helperText = null;
    /**
     * @var array<int, array{label: string, value: string}>
     */
    private array $options = [];
    private bool $multiple = false;
    private mixed $default = null;

    public function text(string $name): self
    {
        return $this->type($name, InputTypeEnum::TEXT);
    }

    public function password(string $name): self
    {
        return $this->type($name, InputTypeEnum::PASSWORD);
    }

    public function email(string $name): self
    {
        return $this->type($name, InputTypeEnum::EMAIL);
    }

    public function select(string $name): self
    {
        return $this->type($name, InputTypeEnum::SELECT);
    }

    public function time(string $name): self
    {
        return $this->type($name, InputTypeEnum::TIME);
    }

    private function type(string $name, InputTypeEnum $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function label(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    public function required(): self
    {
        $this->required = true;
        return $this;
    }

    public function optional(): self
    {
        $this->required = false;
        return $this;
    }

    public function placeholder(?string $placeholder): self
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    public function helperText(?string $text): self
    {
        $this->helperText = $text;
        return $this;
    }

    /**
     * @param array<int, array{label: string, value: string}> $options
     */
    public function options(array $options): self
    {
        $this->options = $options;
        return $this;
    }

    public function multiple(): self
    {
        $this->multiple = true;
        return $this;
    }

    public function default(mixed $value): self
    {
        $this->default = $value;
        return $this;
    }

    public function build(): FieldDTO
    {
        return new FieldDTO(
            $this->type,
            $this->label,
            $this->required,
            $this->placeholder,
            $this->helperText,
            $this->options,
            $this->multiple,
            $this->default,
        );
    }
}
