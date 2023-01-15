<?php

namespace App\Services\ProjectActivity\Repositories;

use App\Models\ProjectActivity;
use App\Services\ProjectActivity\Contracts\ProjectActivityDtoFactoryContract;
use App\Services\ProjectActivity\Contracts\ProjectActivityRepositoryContract;
use App\Services\ProjectActivity\Dtos\ProjectActivityCreateDto;
use App\Services\ProjectActivity\Exceptions\ProjectActivityCreateFailedException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ProjectActivityRepository implements ProjectActivityRepositoryContract
{
    public function __construct(private readonly ProjectActivityDtoFactoryContract $projectActivityDtoFactory)
    {
    }

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

    /**
     * @inheritDoc
     */
    public function findAllByProjectId(Uuid $projectId, int $limit): array
    {
        return $this->projectActivityDtoFactory->createFromModelsList(ProjectActivity::whereProjectId($projectId)->latest()->limit($limit)->get());
    }
}
