<?php

namespace App\Imports;

use App\Models\Visit;
use App\Models\VisitTracking;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class VisitTrackingImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection): void
    {
        foreach ($collection as $item) {

            $visit = Visit::find($item[7]);

            if (is_null($visit)) {
                continue;
            }

            if ($item[11] !== '0000-00-00') {
                VisitTracking::create([
                    'visit_id' => $item[7],
                    'action' => $this->getTrackingAction($item[3]),
                    'status' => $item[10] === 0 ? 'Pendiente' : 'Finalizado',
                    'action_at' => $item[11],
                    'comments' => $item[4],
                    'created_at' => $item[1],
                    'updated_at' => $item[2]
                ]);
            }
        }
    }

    /**
     * @param $item
     * @return string
     */
    public function getTrackingAction($item): string
    {
        $action = 'Llamar al cliente';

        switch ($item) {
            case 2:
                $action = 'Enviar correo';
                break;
            case 3:
                $action = 'Visitar';
                break;
            case 4:
                $action = 'Cotizar';
                break;
            case 5:
                $action = 'Cambios en la condición de venta';
                break;
        }

        return $action;
    }
}
