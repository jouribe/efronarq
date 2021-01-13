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
use App\Traits\Lists;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VisitController extends Controller
{
    use Lists;

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        return view('visits.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        // Get all districts
        $districts = District::all()->pluck('name', 'id');

        // Origins
        $origins = Origin::all()->pluck('name', 'id');

        // Projects
        // TODO: mostrar solo los proyectos para el usuario que inicio sesión.
        $projects = Project::all()->pluck('name', 'id');

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
     * @return Application|Factory|View|Response
     */
    public function store(StoreVisitRequest $request)
    {
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

        // Create visit
        $visit = Visit::create([
            'customer_id' => $customer->id,
            'project_id' => $request->get('project_id'),
            'project_apartment_id' => $request->get('project_apartment_id'),
            'origin_id' => $request->get('origin_id'),
            'interested' => $request->get('interested'),
            'discount' => $request->get('discount') ?? 0,
            'type_financing' => $request->get('type_financing')
        ]);

        // Create visit parking lot
        if ($request->get('project_parking_lot_id') !== null) {
            foreach ($request->get('project_parking_lot_id') as $project_parking_lot_id) {
                VisitParkingLot::create([
                    'visit_id' => $visit->id,
                    'project_parking_lot_id' => $project_parking_lot_id
                ]);
            }
        }

        // Create visit closet.
        if ($request->get('project_closet_id') !== null) {
            foreach ($request->get('project_closet_id') as $project_closet_id) {
                VisitCloset::create([
                    'visit_id' => $visit->id,
                    'project_closet_id' => $project_closet_id
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
     * @return Application|Factory|View|Response
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
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
