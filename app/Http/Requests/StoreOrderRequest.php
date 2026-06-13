<?php

namespace App\Http\Requests;

use App\Enums\ComplexityLevel;
use App\Enums\UrgencyLevel;
use App\Enums\UserRole;
use App\Models\TailoringService;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->role === UserRole::Customer;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'clothing_model_id' => [
                'nullable',
                Rule::exists('clothing_models', 'id')->where('is_active', true),
            ],
            'tailoring_service_id' => [
                'required',
                Rule::exists('tailoring_services', 'id')->where('is_active', true),
            ],
            'material_id' => [
                'nullable',
                Rule::exists('materials', 'id')->where('is_active', true),
            ],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:20'],
            'complexity' => ['nullable', Rule::enum(ComplexityLevel::class)],
            'urgency' => ['nullable', Rule::enum(UrgencyLevel::class)],
            'measurement_values' => ['nullable', 'array'],
            'measurement_values.*' => ['nullable', 'string', 'max:120'],
            'parameters' => ['nullable', 'array'],
            'parameters.*.key' => ['nullable', 'string', 'max:80'],
            'parameters.*.value' => ['nullable', 'string', 'max:120'],
            'customer_comment' => ['nullable', 'string', 'max:2000'],
            'reference_images' => ['nullable', 'array', 'max:5'],
            'reference_images.*' => ['file', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $service = TailoringService::query()
                    ->with('measurementTypes')
                    ->where('is_active', true)
                    ->find($this->input('tailoring_service_id'));

                if (! $service) {
                    return;
                }

                if ($service->requires_model && ! filled($this->input('clothing_model_id'))) {
                    $validator->errors()->add('clothing_model_id', 'Выберите модель изделия для этой услуги.');
                }

                if ($service->requires_model && filled($this->input('clothing_model_id'))) {
                    $isAllowedModel = $service->clothingModels()
                        ->whereKey($this->input('clothing_model_id'))
                        ->exists();

                    if (! $isAllowedModel) {
                        $validator->errors()->add('clothing_model_id', 'Выбранная модель не подходит для этой услуги.');
                    }
                }

                if (! $service->requires_model && filled($this->input('clothing_model_id'))) {
                    $validator->errors()->add('clothing_model_id', 'Для выбранной услуги модель изделия не требуется.');
                }

                if ($service->requires_material && ! filled($this->input('material_id'))) {
                    $validator->errors()->add('material_id', 'Выберите материал для этой услуги.');
                }

                if (! $service->requires_material && filled($this->input('material_id'))) {
                    $validator->errors()->add('material_id', 'Для выбранной услуги материал не требуется.');
                }

                if ($service->applies_quantity && ! filled($this->input('quantity'))) {
                    $validator->errors()->add('quantity', 'Укажите количество.');
                }

                if ($service->applies_complexity && ! filled($this->input('complexity'))) {
                    $validator->errors()->add('complexity', 'Выберите сложность изделия.');
                }

                if ($service->applies_urgency && ! filled($this->input('urgency'))) {
                    $validator->errors()->add('urgency', 'Выберите срок.');
                }

                $values = $this->input('measurement_values', []);
                $allowedMeasurementIds = $service->measurementTypes->pluck('id')->map(fn (int $id): string => (string) $id)->all();

                foreach (array_keys($values) as $measurementId) {
                    if (! in_array((string) $measurementId, $allowedMeasurementIds, true)) {
                        $validator->errors()->add("measurement_values.{$measurementId}", 'Эта мерка не относится к выбранной услуге.');
                    }
                }

                if ($service->requires_measurements) {
                    $service->measurementTypes
                        ->filter(fn ($type): bool => (bool) $type->is_required || (bool) $type->pivot->is_required)
                        ->each(function ($type) use ($values, $validator): void {
                            if (! filled($values[$type->id] ?? null)) {
                                $validator->errors()->add("measurement_values.{$type->id}", "Укажите мерку: {$type->name}.");
                            }
                        });
                } elseif (collect($values)->filter(fn ($value): bool => filled($value))->isNotEmpty()) {
                    foreach (array_keys(array_filter($values, fn ($value): bool => filled($value))) as $measurementId) {
                        $validator->errors()->add("measurement_values.{$measurementId}", 'Для выбранной услуги мерки не требуются.');
                    }
                }
            },
        ];
    }

    protected function prepareForValidation(): void
    {
        if (blank($this->input('clothing_model_id'))) {
            $this->merge(['clothing_model_id' => null]);
        }

        if (blank($this->input('material_id'))) {
            $this->merge(['material_id' => null]);
        }

        if (blank($this->input('quantity'))) {
            $this->merge(['quantity' => null]);
        }

        if (blank($this->input('complexity'))) {
            $this->merge(['complexity' => null]);
        }

        if (blank($this->input('urgency'))) {
            $this->merge(['urgency' => null]);
        }
    }
}
