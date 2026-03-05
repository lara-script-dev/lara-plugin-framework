<?php

declare(strict_types=1);

namespace LaraPluginFramework\Fields;

use LaraPluginFramework\Enums\InputTypeEnum;

final class FieldDTO
{
    /**
     * @param array<int, array{label: string, value: string}> $options
     */
    public function __construct(
        private readonly InputTypeEnum $type,
        private readonly string $label,
        private readonly bool $required = false,
        private readonly ?string $placeholder = null,
        private readonly ?string $helperText = null,
        private readonly array $options = [],
        private readonly bool $multiple = false,
        private readonly mixed $default = null,
    ) {
    }

    /**
     * @return array{
     *   type: string,
     *   label: string,
     *   required: bool,
     *   placeholder: ?string,
     *   helper_text: ?string,
     *   options: array<int, array{label: string, value: string}>,
     *   multiple: bool,
     *   default: mixed,
     * }
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type->value,
            'label' => $this->label,
            'required' => $this->required,
            'placeholder' => $this->placeholder,
            'helper_text' => $this->helperText,
            'options' => $this->options,
            'multiple' => $this->multiple,
            'default' => $this->default,
        ];
    }
}
