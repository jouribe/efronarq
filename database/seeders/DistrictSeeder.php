<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        District::create(["name" => "BREÑA"]);
        District::create(["name" => "CARABAYLLO"]);
        District::create(["name" => "CHACLACAYO"]);
        District::create(["name" => "CHORRILLOS"]);
        District::create(["name" => "CIENEGUILLA"]);
        District::create(["name" => "COMAS"]);
        District::create(["name" => "EL AGUSTINO"]);
        District::create(["name" => "INDEPENDENCIA"]);
        District::create(["name" => "JESÚS MARÍA"]);
        District::create(["name" => "LA MOLINA"]);
        District::create(["name" => "LA VICTORIA"]);
        District::create(["name" => "LINCE"]);
        District::create(["name" => "LOS OLIVOS"]);
        District::create(["name" => "LURIGANCHO"]);
        District::create(["name" => "LURÍN"]);
        District::create(["name" => "MAGDALENA DEL MAR"]);
        District::create(["name" => "MAGDALENA VIEJA"]);
        District::create(["name" => "MIRAFLORES"]);
        District::create(["name" => "PACHACAMAC"]);
        District::create(["name" => "PUCUSANA"]);
        District::create(["name" => "PUENTE PIEDRA"]);
        District::create(["name" => "PUNTA HERMOSA"]);
        District::create(["name" => "PUNTA NEGRA"]);
        District::create(["name" => "RIMAC"]);
        District::create(["name" => "SAN BARTOLO"]);
        District::create(["name" => "SAN BORJA"]);
        District::create(["name" => "SAN ISIDRO"]);
        District::create(["name" => "SAN JUAN DE LURIGANCHO"]);
        District::create(["name" => "SAN JUAN DE MIRAFLORES"]);
        District::create(["name" => "SAN LUIS"]);
        District::create(["name" => "SAN MARTÍN DE PORRES"]);
        District::create(["name" => "SAN MIGUEL"]);
        District::create(["name" => "SANTA ANITA"]);
        District::create(["name" => "SANTA MARÍA DEL MAR"]);
        District::create(["name" => "SANTA ROSA"]);
        District::create(["name" => "SANTIAGO DE SURCO"]);
        District::create(["name" => "SURQUILLO"]);
        District::create(["name" => "VILLA EL SALVADOR"]);
        District::create(["name" => "VILLA MARÍA DEL TRIUNFO"]);
        District::create(["name" => "CALLAO (CERCADO)"]);
        District::create(["name" => "BELLAVISTA"]);
        District::create(["name" => "CARMEN DE LA LEGUA-REYNOSO"]);
        District::create(["name" => "LA PERLA"]);
        District::create(["name" => "LA PUNTA"]);
        District::create(["name" => "VENTANILLA"]);
        District::create(["name" => "MI PERÚ"]);
    }
}
