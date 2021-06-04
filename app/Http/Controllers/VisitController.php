<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVisitRequest;
use App\Http\Requests\UpdateVisitRequest;
use App\Imports\VisitsImport;
use App\Imports\VisitTrackingImport;
use App\Models\Customer;
use App\Models\CustomerDetail;
use App\Models\District;
use App\Models\Exchange;
use App\Models\Origin;
use App\Models\Project;
use App\Models\ProjectApartment;
use App\Models\ProjectCloset;
use App\Models\ProjectParkingLot;
use App\Models\Visit;
use App\Models\VisitCloset;
use App\Models\VisitParkingLot;
use App\Models\VisitQuotation;
use App\Traits\Lists;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Maatwebsite\Excel\Facades\Excel;

class VisitController extends Controller
{
    use Lists;

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('visits.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        // Get all districts
        $districts = District::all()->pluck('name', 'id');

        // Origins
        $origins = Origin::all()->pluck('name', 'id');

        // Projects
        $projects = Project::whereHas('sellers', function ($query) {
            return $query->where('user_id', auth()->user()->id);
        })->whereIsActive(true)
            ->pluck('name', 'id');

        // Discount
        $discountList = [];

        return view('visits.create')->with([
            'districts' => $districts,
            'origins' => $origins,
            'areaRangeList' => $this->areaRange(),
            'financingTypeList' => $this->financingType(),
            'projects' => $projects,
            'boolList' => $this->boolList(),
            'discountList' => $discountList
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreVisitRequest $request
     *
     * @return RedirectResponse
     */
    public function store(StoreVisitRequest $request): RedirectResponse
    {

        // Verify if user exists
        $exist = Customer::whereDni($request->get('dni'))->first();

        if (!$exist) {
            // Create customer
            $customer = Customer::create([
                'first_name' => $request->get('first_name'),
                'last_name' => $request->get('last_name'),
                'dni' => $request->get('dni'),
                'phone' => $request->get('phone'),
                'district_id' => $request->get('district_id'),
                'email' => $request->get('email'),
                'secondary_email' => $request->get('secondary_email')
            ]);

            // Create customer detail
            CustomerDetail::create([
                'customer_id' => $customer->id,
                'area_range' => $request->get('area_range'),
                'bedroom' => $request->get('bedroom'),
                'bathroom' => $request->get('bathroom'),
                'service_room' => $request->get('service_room') !== null
            ]);

            $exist = $customer;
        }

        $exchange = null;

        if ($request->has('exchange') && $request->get('exchange') === '1') {
            $exchange = Exchange::orderByDesc('created_at')->first(['id']);
        }

        // Create visit
        $visit = Visit::create([
            'customer_id' => $exist->id,
            'project_id' => $request->get('project_id'),
            'user_id' => auth()->user()->id,
            'project_apartment_id' => $request->get('project_apartment_id'),
            'origin_id' => $request->get('origin_id'),
            'interested' => $request->get('interested'),
            'type_financing' => $request->get('type_financing'),
            'promotion_id' => $request->get('discount'),
            'exchange_id' => $exchange === null ? null : $exchange->id
        ]);

        ProjectApartment::findOrFail($request->get('project_id'))->update([
            'availability' => 'Reservado'
        ]);

        // Create visit parking lot;
        foreach ($request->get('project_parking_lot_id') as $parking) {
            if (!is_null($parking)) {
                VisitParkingLot::create([
                    'visit_id' => $visit->id,
                    'project_parking_lot_id' => $parking
                ]);

                ProjectParkingLot::findOrFail($parking)->update([
                    'availability' => 'Reservado'
                ]);
            }
        }

        // Create visit closet.
        foreach ($request->get('project_closet_id') as $closet) {
            if (!is_null($closet)) {
                VisitCloset::create([
                    'visit_id' => $visit->id,
                    'project_closet_id' => $closet
                ]);

                ProjectCloset::findOrFail($closet)->update([
                    'availability' => 'Reservado'
                ]);
            }
        }

        return redirect()->route('visits.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Application|Factory|View
     */
    public function show(int $id)
    {
        return view('visits.show')->with([
            'visit' => Visit::whereId($id)->firstOrFail()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Application|Factory|View
     */
    public function edit(int $id)
    {
        // Get all districts
        $districts = District::all()->pluck('name', 'id');

        // Origins
        $origins = Origin::all()->pluck('name', 'id');

        // Projects
        $projects = Project::whereHas('sellers', function ($query) {
            return $query->where('user_id', auth()->user()->id);
        })->whereIsActive(true)
            ->pluck('name', 'id');

        // Discount
        $discountList = [];

        return view('visits.edit')->with([
            'districts' => $districts,
            'origins' => $origins,
            'areaRangeList' => $this->areaRange(),
            'financingTypeList' => $this->financingType(),
            'projects' => $projects,
            'boolList' => $this->boolList(),
            'discountList' => $discountList,
            'visit' => Visit::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateVisitRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(UpdateVisitRequest $request, int $id): RedirectResponse
    {
        $visit = Visit::findOrFail($id);

        $visit->customer->update([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'phone' => $request->get('phone'),
            'dni' => $request->get('dni'),
            'district_id' => $request->get('district_id'),
            'email' => $request->get('email'),
            'secondary_email' => $request->get('secondary_email'),
        ]);

        $visit->customer->details->first()->update([
            'area_range' => $request->get('area_range'),
            'bedroom' => $request->get('bedroom'),
            'bathroom' => $request->get('bathroom')
        ]);

        $visit->update([
            'type_financing' => $request->get('type_financing'),
            'origin_id' => $request->get('origin_id'),
            'project_apartment_id' => $request->get('project_apartment_id'),
            'interested' => $request->get('interested'),
            'promotion_id' => $request->get('discount')
        ]);

        return response()->redirectToRoute('visits.index');
    }

    /**
     * Generates the quote for the visit.
     *
     * @param $id
     *
     * @return mixed
     */
    public function generate($id)
    {
        $visit = Visit::with('project', 'customer', 'apartment', 'closets', 'parkingLots', 'apartment.apartmentType', 'promotion',
            'apartment.apartmentType.priceApartments', 'parkingLots.parkingLot', 'closets.closet', 'project.bank', 'exchange')
            ->find($id);

        $quotation = VisitQuotation::whereVisitId($visit->id)->first();

        if (is_null($quotation)) {
            $data = [
                'visit' => $visit->toArray(),
                'title' => 'Cotización - ' . now()->format('dmYHis') . '-' . $visit->id,
                'discount' => $visit->promotion_id === null ? 0 : $visit->promotion->discount,
                'discount_name' => $visit->promotion_id === null ? '' : $visit->promotion->name
            ];

            $fileName = 'cotizacion-' . now()->format('dmYHis') . '-' . $visit->id . '.pdf';

            /** @noinspection PhpUndefinedClassInspection */
            /** @noinspection PhpFullyQualifiedNameUsageInspection */
            $pdf = \PDF::loadView('visits.quote', $data)
                ->save(storage_path('app/public/quotations/' . $fileName));

            VisitQuotation::create([
                'visit_id' => $visit->id,
                'file' => "quotations/$fileName"
            ]);

            // Update visit status to 'Cotización'
            $visit->status = 'Cotización';
            $visit->save();

            return $pdf->stream($fileName);
        }

        return response()->file('storage/' . $quotation->file);
    }

    /**
     * Import visit data.
     */
    public function import(): void
    {
        Excel::import(new VisitsImport, 'imports/efron_visitas.xlsx', 'public', \Maatwebsite\Excel\Excel::XLSX);
    }

    /**
     * Import visit tracking.
     */
    public function tracking(): void
    {
        Excel::import(new VisitTrackingImport, 'imports/efron_seguimiento.xlsx', 'public', \Maatwebsite\Excel\Excel::XLSX);
    }
}
