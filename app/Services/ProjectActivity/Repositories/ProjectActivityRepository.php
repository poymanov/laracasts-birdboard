<?php

namespace App\Services\ProjectActivity\Repositories;

use App\Models\ProjectActivity;
use App\Services\ProjectActivity\Contracts\ProjectActivityRepositoryContract;
use App\Services\ProjectActivity\Dtos\ProjectActivityCreateDto;
use App\Services\ProjectActivity\Exceptions\ProjectActivityCreateFailedException;

class ProjectActivityRepository implements ProjectActivityRepositoryContract
{
    /**
     * @inheritDoc
     */
    public function create(ProjectActivityCreateDto $projectActivityCreateDto): void
    {
        $projectActivity             = new ProjectActivity();
        $projectActivity->project_id = $projectActivityCreateDto->projectId->value();
        $projectActivity->user_id    = $projectActivityCreateDto->userId;
        $projectActivity->type       = $projectActivityCreateDto->type;

        if ($projectActivityCreateDto->oldValue) {
            $projectActivity->old_value = $projectActivityCreateDto->oldValue;
        }

        if ($projectActivityCreateDto->newValue) {
            $projectActivity->new_value = $projectActivityCreateDto->newValue;
        }

        if (!$projectActivity->save()) {
            throw new ProjectActivityCreateFailedException();
        }
    }
}
