<?php

namespace App\Enums;

enum ServicePricingMode: string
{
    case ModelBased = 'model_based';
    case Alteration = 'alteration';
    case Fixed = 'fixed';

    public function label(): string
    {
        return match ($this) {
            self::ModelBased => 'По модели изделия',
            self::Alteration => 'Коррекция готового изделия',
            self::Fixed => 'Фиксированная услуга',
        };
    }
}
