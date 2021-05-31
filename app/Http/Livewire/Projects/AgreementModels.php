<?php

namespace App\Http\Livewire\Projects;

use App\Models\ProjectAgreementModel;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class AgreementModels extends Component
{
    /**
     * @var mixed $projectAgreementModelId
     */
    public $projectAgreementModelId;

    /**
     * @var mixed $project
     */
    public $project;

    /**
     * @var $content
     */
    public $content;

    public function mount(): void
    {
        $agreements = $this->project->agreementModels;

        if ($agreements) {
            $this->content = $agreements->first()->content;
            $this->projectAgreementModelId = $agreements->first()->id;
        }
    }

    /**
     * Get the view / contents that represent the component.
     * w
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('livewire.projects.agreement-models');
    }

    public function store(): void
    {
        ProjectAgreementModel::updateOrCreate([
            'id' => $this->projectAgreementModelId
        ], [
            'project_id' => $this->project->id,
            'content' => $this->content
        ]);
    }
}
