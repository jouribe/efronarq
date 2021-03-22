<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVisitRequest;
use App\Models\Customer;
use App\Models\CustomerDetail;
use App\Models\District;
use App\Models\Origin;
use App\Models\Project;
use App\Models\Visit;
use App\Models\VisitCloset;
use App\Models\VisitParkingLot;
use App\Models\VisitQuotation;
use App\Traits\Lists;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

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
     * @return Application|Factory|View
     */
    public function store(StoreVisitRequest $request)
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

        // Create visit
        $visit = Visit::create([
            'customer_id' => $exist->id,
            'project_id' => $request->get('project_id'),
            'user_id' => auth()->user()->id,
            'project_apartment_id' => $request->get('project_apartment_id'),
            'origin_id' => $request->get('origin_id'),
            'interested' => $request->get('interested'),
            'type_financing' => $request->get('type_financing')
        ]);

        // Create visit parking lot;
        foreach ($request->get('project_parking_lot_id') as $parking) {
            if (!is_null($parking)) {
                VisitParkingLot::create([
                    'visit_id' => $visit->id,
                    'project_parking_lot_id' => $parking
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
            }
        }
        return view('visits.index');
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
        return view('visits.quote')->with('visit', Visit::find($id));
    }

    /**
     * Generates the quote for the visit.
     *
     * @param $id
     *
     * @return mixed
     */
    public function generate($id): mixed
    {
        $visit = Visit::with('project', 'customer', 'apartment', 'closets', 'parkingLots', 'apartment.apartmentType',
            'apartment.apartmentType.priceApartments', 'parkingLots.parkingLot', 'closets.closet', 'project.bank')
            ->find($id);

        $quotation = VisitQuotation::whereVisitId($visit->id)->first();

        if (is_null($quotation)) {
            $data = [
                'visit' => $visit->toArray(),
                'title' => 'Cotización - ' . now()->format('dmYHis') . '-' . $visit->id,
                'discount' => 0
            ];

            $fileName = 'cotizacion-' . now()->format('dmYHis') . '-' . $visit->id . '.pdf';

            /** @noinspection PhpUndefinedClassInspection */
            /** @noinspection PhpFullyQualifiedNameUsageInspection */
            $pdf = \PDF::loadView('visits.quote', $data)
                ->save(storage_path('app/public/quotations/'. $fileName));

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
}
