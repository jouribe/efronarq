<?php

namespace App\Http\Livewire\Visits;

use App\Models\ProjectApartment;
use App\Models\ProjectCloset;
use App\Models\ProjectParkingLot;
use Livewire\Component;

class Project extends Component
{
    /**
     * @var array[] $projects
     */
    public $projects;

    /**
     * @var $project
     */
    public $project_id;

    /**
     * @var $project_parking_lot_id
     */
    public $project_parking_lot_id;

    /**
     * @var $project_closet_id
     */
    public $project_closet_id;

    /**
     * @var array[] $boolList
     */
    public $boolList;

    /**
     * @var array[] $apartmentList
     */
    public $apartmentList = [];

    /**
     * @var array[] $parkingLotList
     */
    public $parkingLotList = [];

    /**
     * @var array $closetList
     */
    public $closetList = [];

    /**
     * @var array $parkingLotDropDowns
     */
    public $parkingLotDropDowns = [];

    /**
     * @var array $closetDropDowns
     */
    public $closetDropDowns = [];

    /**
     * @var $discountList
     */
    public $discountList;

    /**
     * @var int $i
     */
    public $i = 1;

    /**
     * @var int $j
     */
    public $j = 1;

    public function render()
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
