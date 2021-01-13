<?php

namespace App\Traits;

trait Lists
{
    /**
     * Area range list
     *
     * @return string[]
     */
    public function areaRange(): array
    {
        return [
            '40 a 70' => '40 a 70',
            '+70 a 90' => '+70 a 90',
            '+90 a 120' => '+90 a 120',
            '+120 a 150' => '+120 a 150',
            '+150 a 180' => '+150 a 180',
            '+180 a 200' => '+180 a 200',
            '+200' => '+200'
        ];
    }

    /**
     * Financing type list.
     *
     * @return string[]
     */
    public function financingType(): array
    {
        return [
            'Crédito hipotecario' => 'Crédito hipotecario',
            'Financiamiento directo' => 'Financiamiento directo'
        ];
    }

    /**
     * Bool list.
     *
     * @return string[]
     */
    public function boolList(): array
    {
        return [
            true => 'Si',
            false => 'No'
        ];
    }

    /**
     * Action list
     *
     * @return string[]
     */
    public function action(): array
    {
        return [
            'Llamar al cliente' => 'Llamar al cliente',
            'Enviar correo' => 'Enviar correo',
            'Visitar' => 'Visitar',
            'Cotizar' => 'Cotizar',
            'Cambios en la condición de venta' => 'Cambios en la condición de venta'
        ];
    }
}
