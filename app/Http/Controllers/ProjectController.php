<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Bank;
use App\Models\District;
use App\Models\Project;
use App\Models\ProjectAddress;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
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
        $path = null;

        if ($request->has('logo')) {
            /** @noinspection NullPointerExceptionInspection */
            $path = $request->file('logo')->store('project-logos', 'public');
        }

        // Add project.
        $project = Project::create([
            'name' => $request->get('name'),
            'logo' => $path,
            'description' => $request->get('description'),
            'legal' => $request->get('legal'),
            'status' => $request->get('status'),
            'bank_id' => $request->get('bank_id')
        ]);

        // Add Address
        ProjectAddress::create([
            'project_id' => $project->id,
            'district_id' => $request->get('district_id'),
            'type' => 'Principal',
            'address' => $request->get('address'),
            'logo'
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
     * @param int $id
     * @return Application|Factory|View|Response
     */
    public function edit(int $id): Factory|View|Response|Application
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

        return view('projects.edit')->with([
            'project' => Project::whereId($id)->first(),
            'districts' => $districts,
            'projectStatus' => $projectStatus,
            'banks' => $banks
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProjectRequest $request
     * @param int $id
     * @return RedirectResponse|Response
     */
    public function update(UpdateProjectRequest $request, int $id): Response|RedirectResponse
    {
        Project::whereId($id)->update([
            'name' => $request->get('name'),
            'status' => $request->get('status'),
            'description' => $request->get('description'),
            'legal' => $request->get('legal'),
            'bank_id' => $request->get('bank_id')
        ]);

        ProjectAddress::whereProjectId($id)->where('type', 'Principal')->update([
            'address' => $request->get('address'),
            'district_id' => $request->get('district_id')
        ]);

        if ($request->has('logo')) {
            /** @noinspection NullPointerExceptionInspection */
            ProjectAddress::whereId($id)->update([
                'logo' => $request->file('logo')->store('project-logos', 'public')
            ]);
        }

        return redirect()->route('projects.index')->with('success', __('Project updated successfully'));
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
