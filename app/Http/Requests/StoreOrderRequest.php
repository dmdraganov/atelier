<?php

namespace App\Http\Requests;

use App\Enums\ComplexityLevel;
use App\Enums\UrgencyLevel;
use App\Enums\UserRole;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
                'required',
                Rule::exists('clothing_models', 'id')->where('is_active', true),
            ],
            'material_id' => [
                'required',
                Rule::exists('materials', 'id')->where('is_active', true),
            ],
            'quantity' => ['required', 'integer', 'min:1', 'max:20'],
            'complexity' => ['required', Rule::enum(ComplexityLevel::class)],
            'urgency' => ['required', Rule::enum(UrgencyLevel::class)],
            'measurements' => ['nullable', 'array'],
            'measurements.*.key' => ['nullable', 'string', 'max:80'],
            'measurements.*.value' => ['nullable', 'string', 'max:120'],
            'parameters' => ['nullable', 'array'],
            'parameters.*.key' => ['nullable', 'string', 'max:80'],
            'parameters.*.value' => ['nullable', 'string', 'max:120'],
            'customer_comment' => ['nullable', 'string', 'max:2000'],
            'reference_images' => ['nullable', 'array', 'max:5'],
            'reference_images.*' => ['file', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];
    }
}
