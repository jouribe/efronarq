<?php

namespace App\Traits;

trait Prices
{
    /**
     * Discount free area.
     *
     * @param int $discount
     * @param float $area
     * @param float $price
     *
     * @return float
     */
    public static function freeAreaTotal(int $discount, float $area, float $price): float
    {
        return ($area * $price) - (($area * $price) * $discount / 100);
    }

    /**
     * Roofed area price.
     *
     * @param float $area
     * @param float $price
     *
     * @return float
     */
    public static function roofedAreaTotal(float $area, float $price): float
    {
        return $area * $price;
    }

    /**
     * Price total
     *
     * @param float $free
     * @param float $roofed
     * @param int $presale
     * @param int $delivery
     *
     * @return float
     */
    public static  function areaPriceTotal(float $free, float $roofed, int $presale = 0, int $delivery = 0): float
    {
        return ($free + $roofed) - (($free + $roofed) * $presale / 100) - (($free + $roofed) * $delivery / 100);
    }
}
