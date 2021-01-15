<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Models\Bank;
use App\Models\District;
use App\Models\Project;
use App\Models\ProjectAddress;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index(): Factory|View|Response|Application
    {
        return view('projects.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create(): Factory|View|Response|Application
    {
        // project status
        $projectStatus = [
            'Preregistrado' => 'Preregistrado',
            'Preventa' => 'Preventa',
            'En construcción' => 'En construcción',
            'Entrega' => 'Entrega',
            'Finalizado' => 'Finalizado'
        ];

        // districts
        $districts = District::all()->pluck("name", "id");

        // Banks
        $banks = Bank::whereIsActive(true)->pluck('description', 'id');

        return view('projects.create')
            ->with([
                'projectStatus' => $projectStatus,
                'districts' => $districts,
                'banks' => $banks
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProjectRequest $request
     *
     * @return RedirectResponse
     */
    public function store(StoreProjectRequest $request): RedirectResponse
    {
        // Add project.
        $project = Project::create($request->except(["address", "district_id"]));

        // Add Address
        ProjectAddress::create([
            'project_id' => $project->id,
            'district_id' => $request->get('district_id'),
            'type' => 'Principal',
            'address' => $request->get('address')
        ]);

        // Return to show view.
        return redirect()->route('projects.show', $project->id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|Response
     */
    public function show(int $id): Factory|View|Response|Application
    {
        return view('projects.show')->with([
            'project' => Project::whereId($id)->firstOrFail()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
