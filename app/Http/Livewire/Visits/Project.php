<?php

/** @noinspection UnknownInspectionInspection */

namespace App\Http\Livewire\Visits;

use App\Models\ProjectApartment;
use App\Models\ProjectCloset;
use App\Models\ProjectParkingLot;
use App\Models\Promotion;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Project extends Component
{
    /**
     * @var mixed $projects
     */
    public $projects;

    /**
     * @var mixed $project
     */
    public $project_id;

    /**
     * @var mixed $project_parking_lot_id
     */
    public $project_parking_lot_id;

    /**
     * @var mixed $project_closet_id
     */
    public $project_closet_id;

    /**
     * @var array[] $boolList
     */
    public array $boolList;

    /**
     * @var mixed $apartmentList
     */
    public $apartmentList = [];

    /**
     * @var mixed $parkingLotList
     */
    public $parkingLotList = [];

    /**
     * @var mixed $closetList
     */
    public $closetList = [];

    /**
     * @var mixed $parkingLotDropDowns
     */
    public $parkingLotDropDowns = [];

    /**
     * @var mixed $closetDropDowns
     */
    public $closetDropDowns = [];

    /**
     * @var mixed $discountList
     */
    public $discountList;

    /**
     * @var int $i
     */
    public int $i = 1;

    /**
     * @var int $j
     */
    public int $j = 1;

    /**
     * @var mixed $visit
     */
    public $visit;

    /**
    * @var mixed $interested
    */
    public $interested;

    /**
    * @var mixed $exchangeRateList
    */
    public $exchangeRateList = [
        1 => 'Si',
        0 => 'No'
    ];

    /**
     * @var mixed $projectCurrency
     */
    public $projectCurrency;

    /**
     * Render view.
     *
     * @return Factory|View|Application
     */
    public function render()
    {
        if (!is_null($this->visit)) {
            $this->project_id = $this->visit->project_id;
        }

        if(!is_null($this->project_id)) {
            $this->discountList = Promotion::whereProjectId($this->project_id)
                ->where('start_at' , '<=', now())
                ->where('end_at', '>=', now())
                ->pluck('name', 'id');

            $this->projectCurrency = \App\Models\Project::whereId($this->project_id)->first()->currency;
        }

        $this->getProjectApartmentList();
        $this->getProjectParkingLotList();
        $this->getProjectClosetList();

        return view('livewire.visits.project');
    }

    /**
     * @param $i
     * @noinspection PhpUnused
     */
    public function addParkingLot($i): void
    {
        ++$i;
        $this->i = $i;
        $this->parkingLotDropDowns[] = $i;
    }

    /**
     * @param $j
     */
    public function addCloset($j): void
    {
        ++$j;
        $this->j = $j;
        $this->closetDropDowns[] = $j;
    }

    /**
     * @param $i
     */
    public function removeParkingLot($i): void
    {
        unset($this->parkingLotDropDowns[$i]);
    }

    /**
     * @param $j
     */
    public function removeCloset($j): void
    {
        unset($this->closetDropDowns[$j]);
    }

    /**
     * Get project apartments list
     *
     * @return void
     */
    public function getProjectApartmentList(): void
    {
        $this->apartmentList = ProjectApartment::leftJoin('project_apartment_types', 'project_apartments.apartment_type_id', 'project_apartment_types.id')->where('project_apartments.project_id', $this->project_id);

        if (is_null($this->visit)) {
            $this->apartmentList = $this->apartmentList->where('project_apartments.availability', '=', 'Disponible');
        } else {
            $this->apartmentList = $this->apartmentList->where('project_apartments.id', $this->visit->project_apartment_id);
        }

        $this->apartmentList = $this->apartmentList->selectRaw("project_apartments.id as id, CONCAT(project_apartments.name, ': Tipo ', project_apartment_types.type_name, ' - ', SUM(project_apartment_types.roofed_area + project_apartment_types.free_area), ' mts.') as text")
            ->groupBy('project_apartments.id', 'project_apartments.name', 'project_apartment_types.type_name', 'project_apartment_types.free_area', 'project_apartment_types.roofed_area');

        $this->apartmentList = $this->apartmentList->pluck('text', 'id');
    }

    /**
     * Get parking lot price
     *
     * @return void
     */
    public function getProjectParkingLotList(): void
    {
        $this->parkingLotList = ProjectParkingLot::whereProjectId($this->project_id);

        if (is_null($this->visit)) {
            $this->parkingLotList = $this->parkingLotList->where('project_parking_lots.availability', '=', 'Disponible');
        }

        $this->parkingLotList = $this->parkingLotList
            ->selectRaw("id, CONCAT(parking_lot, ': ', floor, ' - ', SUM(roofed_area + free_area), ' mts.') as text")
            ->groupBy('id', 'parking_lot', 'floor', 'roofed_area', 'free_area')
            ->pluck('text', 'id');
    }

    /**
     * Get project closet list.
     *
     * @return void
     */
    public function getProjectClosetList(): void
    {
        $this->closetList = ProjectCloset::whereProjectId($this->project_id);

        if (is_null($this->visit)) {
            $this->closetList = $this->closetList->where('project_closets.availability', '=', 'Disponible');
        }

        $this->closetList = $this->closetList
            ->selectRaw("id, CONCAT(floor, ' - ', closet, ': ', roofed_area, ' mts.') as text")
            ->groupBy('id', 'floor', 'closet', 'roofed_area')
            ->pluck('text', 'id');
    }
}
