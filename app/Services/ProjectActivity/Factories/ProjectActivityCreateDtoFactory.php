<?php

namespace App\Services\ProjectActivity\Factories;

use App\Enums\ProjectActivityTypeEnum;
use App\Services\ProjectActivity\Contracts\ProjectActivityCreateDtoFactoryContract;
use App\Services\ProjectActivity\Dtos\ProjectActivityCreateDto;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ProjectActivityCreateDtoFactory implements ProjectActivityCreateDtoFactoryContract
{
    /**
     * @inheritDoc
     */
    public function createTypeCreateProject(int $userId, Uuid $projectId): ProjectActivityCreateDto
    {
        $projectActivityCreateDto            = new ProjectActivityCreateDto();
        $projectActivityCreateDto->userId    = $userId;
        $projectActivityCreateDto->projectId = $projectId;
        $projectActivityCreateDto->type      = ProjectActivityTypeEnum::CREATE_PROJECT->value;

        return $projectActivityCreateDto;
    }

    /**
     * @inheritDoc
     */
    public function createTypeUpdateProject(int $userId, Uuid $projectId, string $type, ?string $oldValue, string $newValue): ProjectActivityCreateDto
    {
        $projectActivityCreateDto            = new ProjectActivityCreateDto();
        $projectActivityCreateDto->userId    = $userId;
        $projectActivityCreateDto->projectId = $projectId;
        $projectActivityCreateDto->type      = $type;
        $projectActivityCreateDto->oldValue  = $oldValue;
        $projectActivityCreateDto->newValue  = $newValue;

        return $projectActivityCreateDto;
    }

    /**
     * @inheritDoc
     */
    public function createTypeCreateTask(int $userId, Uuid $projectId, string $newValue): ProjectActivityCreateDto
    {
        $projectActivityCreateDto            = new ProjectActivityCreateDto();
        $projectActivityCreateDto->userId    = $userId;
        $projectActivityCreateDto->projectId = $projectId;
        $projectActivityCreateDto->type      = ProjectActivityTypeEnum::CREATE_TASK->value;
        $projectActivityCreateDto->newValue  = $newValue;

        return $projectActivityCreateDto;
    }

    /**
     * @inheritDoc
     */
    public function createUpdateTask(int $userId, Uuid $projectId, string $oldValue, string $newValue): ProjectActivityCreateDto
    {
        $projectActivityCreateDto            = new ProjectActivityCreateDto();
        $projectActivityCreateDto->userId    = $userId;
        $projectActivityCreateDto->projectId = $projectId;
        $projectActivityCreateDto->type      = ProjectActivityTypeEnum::UPDATE_TASK->value;
        $projectActivityCreateDto->oldValue  = $oldValue;
        $projectActivityCreateDto->newValue  = $newValue;

        return $projectActivityCreateDto;
    }

    /**
     * @inheritDoc
     */
    public function createCompleteTask(int $userId, Uuid $projectId, string $taskBody): ProjectActivityCreateDto
    {
        $projectActivityCreateDto            = new ProjectActivityCreateDto();
        $projectActivityCreateDto->userId    = $userId;
        $projectActivityCreateDto->projectId = $projectId;
        $projectActivityCreateDto->type      = ProjectActivityTypeEnum::COMPLETE_TASK->value;
        $projectActivityCreateDto->oldValue  = $taskBody;

        return $projectActivityCreateDto;
    }

    /**
     * @inheritDoc
     */
    public function createIncompleteTask(int $userId, Uuid $projectId, string $taskBody): ProjectActivityCreateDto
    {
        $projectActivityCreateDto            = new ProjectActivityCreateDto();
        $projectActivityCreateDto->userId    = $userId;
        $projectActivityCreateDto->projectId = $projectId;
        $projectActivityCreateDto->type      = ProjectActivityTypeEnum::INCOMPLETE_TASK->value;
        $projectActivityCreateDto->oldValue  = $taskBody;

        return $projectActivityCreateDto;
    }

    /**
     * @inheritDoc
     */
    public function createNewMember(int $userId, Uuid $projectId): ProjectActivityCreateDto
    {
        $projectActivityCreateDto            = new ProjectActivityCreateDto();
        $projectActivityCreateDto->userId    = $userId;
        $projectActivityCreateDto->projectId = $projectId;
        $projectActivityCreateDto->type      = ProjectActivityTypeEnum::NEW_MEMBER->value;

        return $projectActivityCreateDto;
    }

    /**
     * @inheritDoc
     */
    public function createDeleteMember(int $userId, Uuid $projectId): ProjectActivityCreateDto
    {
        $projectActivityCreateDto            = new ProjectActivityCreateDto();
        $projectActivityCreateDto->userId    = $userId;
        $projectActivityCreateDto->projectId = $projectId;
        $projectActivityCreateDto->type      = ProjectActivityTypeEnum::DELETE_MEMBER->value;

        return $projectActivityCreateDto;
    }
}
