<?php

namespace App\Http\Livewire\Visits;

use App\Models\ProjectApartment;
use App\Models\ProjectCloset;
use App\Models\ProjectParkingLot;
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
     * Render view.
     *
     * @return Factory|View|Application
     */
    public function render(): Factory|View|Application
    {
        if (!empty($this->project_id)) {
            $this->apartmentList = ProjectApartment::leftJoin('project_apartment_types', 'project_apartments.apartment_type_id', 'project_apartment_types.id')
                ->where('project_apartments.project_id', '=', $this->project_id)
                ->pluck('project_apartment_types.type_name', 'project_apartments.id');

            $this->parkingLotList = ProjectParkingLot::whereProjectId($this->project_id)->pluck('floor', 'id');

            $this->closetList = ProjectCloset::whereProjectId($this->project_id)->pluck('closet', 'id');
        }

        return view('livewire.visits.project');
    }

    /**
     * @param $i
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
}
