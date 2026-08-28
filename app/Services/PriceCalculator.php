<?php

namespace App\Services;

use App\Models\Color;
use App\Models\Material;
use App\Models\Sidecar;

class PriceCalculator
{
    public static function calculate(
        Sidecar $sidecar,
        ?Material $material = null,
        ?Color $color = null,
        array $accessoryIds = [],
        float $additionalCost = 0
    ): float {
        $total = (float) $sidecar->base_price;

        if ($material) {
            $total += (float) $material->additional_price;
        }

        if ($color) {
            $total += (float) $color->additional_price;
        }

        if ($accessoryIds) {
            foreach ($accessoryIds as $id => $accessory) {
                $total += (float) $accessory->price;
            }
        }

        $total += $additionalCost;

        return round($total, 2);
    }

    public static function format(float $amount): string
    {
        return '₱' . number_format($amount, 2);
    }
}
