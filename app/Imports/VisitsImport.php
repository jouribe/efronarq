<?php

namespace App\Imports;

use App\Models\Customer;
use App\Models\CustomerDetail;
use App\Models\Visit;
use App\Models\VisitCloset;
use App\Models\VisitParkingLot;
use App\Models\VisitQuotation;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class VisitsImport implements ToCollection
{
    /**
     * @param Collection $collection
     * @return void
     */
    public function collection(Collection $collection): void
    {
        foreach ($collection as $item) {
            // Validar si tiene proyecto
            if (!is_null($item[22])) {

                $customer = null;

                if (!is_null($item[7])) {
                    $customer = Customer::whereEmail($item[7])->first();
                }

                $customer = Customer::updateOrCreate([
                    'id' => $customer === null ? null : $customer->id
                ],[
                    'first_name' => ucfirst($item[5]),
                    'last_name' => ucfirst($item[6]),
                    'email' => $item[7],
                    'dni' => is_null($item[4]) ? null : (string)$item[4],
                    'phone' => is_null($item[8]) ? null : (string)$item[8],
                    'district_id' => is_null($item[17]) ? 1 : $item[17],
                    'prueba' => 1
                ]);

                $areaRange = '40 a 70';

                switch ($item[16]) {
                    case 2:
                        $areaRange = '+70 a 90';
                        break;
                    case 3:
                        $areaRange = '+90 a 120';
                        break;
                    case 4:
                        $areaRange = '+120 a 150';
                        break;
                    case 5:
                        $areaRange = '+150 a 180';
                        break;
                    case 6:
                        $areaRange = '+180 a 200';
                        break;
                    case 7:
                        $areaRange = '+200';
                        break;
                }

                $details = CustomerDetail::create([
                    'customer_id' => $customer->id,
                    'area_range' => $areaRange,
                    'bedroom' => is_null($item[14]) ? 0 : $item[14],
                    'bathroom' => is_null($item[13]) ? 0 : $item[13],
                    'service_room' => is_null($item[15]) ? 0 : $item[15]
                ]);

                $user = 2;

                switch ($item[27]) {
                    case 12:
                        $user = 3;
                        break;
                    case 15:
                        $user = 5;
                        break;
                    case 14:
                        $user = 4;
                        break;
                    case 17:
                        $user = 7;
                        break;
                }

                $interested = 1;

                if ($item[10] === 2 || is_null($item[10])) {
                    $interested = 0;
                }

                $financing = 'Crédito Hipotecario';

                if ($item[11] === 2 || is_null($item[11])) {
                    $financing = 'Financiamiento Directo';
                }

                $status = 'Visita';

                if ($item[30] === 1 && (!is_null($item[18] || !is_null($item[19]) || !is_null($item[20])))) {
                    $status = 'Cotización';
                }

                $visit = Visit::create([
                    'id' => $item[0],
                    'customer_id' => $customer->id,
                    'project_id' => $item[22],
                    'origin_id' => $item[21],
                    'user_id' => $user,
                    'project_apartment_id' => $item[18],
                    'interested' => $interested,
                    'type_financing' => $financing,
                    'promotion_id' => $item[47],
                    'status' => $status,
                    'created_at' => $item[1],
                    'updated_at' => $item[2]
                ]);

                if ($status === 'Cotización') {
                    VisitQuotation::create([
                        'visit_id' => $visit->id,
                        'file' => $item[31]
                    ]);
                }

                if (!is_null($item[19])) {
                    VisitParkingLot::create([
                        'visit_id' => $visit->id,
                        'project_parking_lot_id' => $item[19]
                    ]);
                }

                if (!is_null($item[23])) {
                    VisitParkingLot::create([
                        'visit_id' => $visit->id,
                        'project_parking_lot_id' => $item[23]
                    ]);
                }

                if (!is_null($item[24])) {
                    VisitParkingLot::create([
                        'visit_id' => $visit->id,
                        'project_parking_lot_id' => $item[24]
                    ]);
                }

                if (!is_null($item[25])) {
                    VisitParkingLot::create([
                        'visit_id' => $visit->id,
                        'project_parking_lot_id' => $item[25]
                    ]);
                }

                if (!is_null($item[20])) {
                    VisitCloset::create([
                        'visit_id' => $visit->id,
                        'project_closet_id' => $item[20]
                    ]);
                }

                if (!is_null($item[26])) {
                    VisitCloset::create([
                        'visit_id' => $visit->id,
                        'project_closet_id' => $item[26]
                    ]);
                }
            }
        }
    }
}
