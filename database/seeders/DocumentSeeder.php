<?php

namespace Database\Seeders;

use App\Models\Document;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Document::create([
            'type' => 'Crédito Hipotecario Con Carta Fianza',
            'name' => 'Banco del cliente solicita documentos a la inmobiliaria'
        ]);

        Document::create([
            'type' => 'Crédito Hipotecario Con Carta Fianza',
            'name' => 'Inmobiliaria solicita ratificación de carta de aprobación'
        ]);

        Document::create([
            'type' => 'Crédito Hipotecario Con Carta Fianza',
            'name' => 'Banco del cliente envía tenor (requisitos)'
        ]);

        Document::create([
            'type' => 'Crédito Hipotecario Con Carta Fianza',
            'name' => 'Inmobiliaria solicita carta fianza a su banco'
        ]);

        Document::create([
            'type' => 'Crédito Hipotecario Con Carta Fianza',
            'name' => 'Banco del cliente recibe carta fianza'
        ]);

        Document::create([
            'type' => 'Crédito Hipotecario Con Carta Fianza',
            'name' => 'Desembolso del crédito hipotecario'
        ]);

        Document::create([
            'type' => 'Crédito Hipotecario Con Carta Fianza',
            'name' => 'Firma de escritura pública'
        ]);

        Document::create([
            'type' => 'Crédito Hipotecario Con Carta Fianza',
            'name' => 'Otros'
        ]);

        Document::create([
            'type' => 'Crédito Hipotecario Sin Carta Fianza',
            'name' => 'Cliente vuelve a enviar información solicitada'
        ]);

        Document::create([
            'type' => 'Crédito Hipotecario Sin Carta Fianza',
            'name' => 'Ingreso de operación a crédito'
        ]);

        Document::create([
            'type' => 'Crédito Hipotecario Sin Carta Fianza',
            'name' => 'Aprobación o desaprobación de crédito'
        ]);

        Document::create([
            'type' => 'Crédito Hipotecario Sin Carta Fianza',
            'name' => 'Firma en notaría (ingreso a CH, tasación, estudio de títulos)'
        ]);

        Document::create([
            'type' => 'Crédito Hipotecario Sin Carta Fianza',
            'name' => 'Desembolso del crédito hipotecario'
        ]);

        Document::create([
            'type' => 'Crédito Hipotecario Sin Carta Fianza',
            'name' => 'Firma de escritura pública'
        ]);

        Document::create([
            'type' => 'Crédito Hipotecario Sin Carta Fianza',
            'name' => 'Otros'
        ]);
    }
}
