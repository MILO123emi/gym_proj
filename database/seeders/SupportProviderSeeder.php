<?php

namespace Database\Seeders;

use App\Models\SupportProvider;
use Illuminate\Database\Seeder;

class SupportProviderSeeder extends Seeder
{
    public function run(): void
    {
        $providers = [
            ['nombre' => 'TecnoGym Servicios', 'servicio' => 'Mantenimiento de máquinas', 'telefono' => '98765432', 'email' => 'tecnogym@soporte.hn'],
            ['nombre' => 'Frío Clima HN', 'servicio' => 'Revisión y reparación de AC', 'telefono' => '32765432', 'email' => 'frio@soporte.hn'],
            ['nombre' => 'ElectroCentro', 'servicio' => 'Electricista industrial', 'telefono' => '89761234', 'email' => 'electro@soporte.hn'],
            ['nombre' => 'AquaPlom HN', 'servicio' => 'Plomería y fugas', 'telefono' => '23761234', 'email' => 'plom@soporte.hn'],
            ['nombre' => 'Aire Plus', 'servicio' => 'Ventiladores y extracción', 'telefono' => '98761111', 'email' => 'aireplus@soporte.hn'],
            ['nombre' => 'LimpiaPro', 'servicio' => 'Limpieza profunda', 'telefono' => '33770011', 'email' => 'limpia@soporte.hn'],
            ['nombre' => 'Rótulos Centro', 'servicio' => 'Señalización interna', 'telefono' => '88770022', 'email' => 'rotulos@soporte.hn'],
        ];

        foreach ($providers as $provider) {
            SupportProvider::updateOrCreate(
                ['nombre' => $provider['nombre']],
                $provider + ['notas' => 'Proveedor homologado.', 'activo' => true]
            );
        }
    }
}
