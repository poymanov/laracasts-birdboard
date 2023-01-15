<?php

namespace App\Services\ProjectActivity;

use App\Services\ProjectActivity\Contracts\ProjectActivityCreateDtoFactoryContract;
use App\Services\ProjectActivity\Contracts\ProjectActivityRepositoryContract;
use App\Services\ProjectActivity\Contracts\ProjectActivityServiceContract;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class ProjectActivityService implements ProjectActivityServiceContract
{
    public function __construct(
        private readonly ProjectActivityCreateDtoFactoryContract $projectActivityCreateDtoFactory,
        private readonly ProjectActivityRepositoryContract $projectActivityRepository,
        private readonly int $activitiesLimit
    ) {
    }

    /**
     * @inheritDoc
     */
    public function createCreateProject(int $userId, Uuid $projectId): void
    {
        $projectActivityCreateDto = $this->projectActivityCreateDtoFactory->createTypeCreateProject($userId, $projectId);
        $this->projectActivityRepository->create($projectActivityCreateDto);
    }

    /**
     * @inheritDoc
     */
    public function createUpdateProject(int $userId, Uuid $projectId, string $type, ?string $oldValue, string $newValue): void
    {
        $projectActivityCreateDto = $this->projectActivityCreateDtoFactory->createTypeUpdateProject($userId, $projectId, $type, $oldValue, $newValue);
        $this->projectActivityRepository->create($projectActivityCreateDto);
    }

    /**
     * @inheritDoc
     */
    public function createCreateTask(int $userId, Uuid $projectId, string $newValue): void
    {
        $projectActivityCreateDto = $this->projectActivityCreateDtoFactory->createTypeCreateTask($userId, $projectId, $newValue);
        $this->projectActivityRepository->create($projectActivityCreateDto);
    }

    /**
     * @inheritDoc
     */
    public function createUpdateTask(int $userId, Uuid $projectId, string $oldValue, string $newValue): void
    {
        $projectActivityCreateDto = $this->projectActivityCreateDtoFactory->createUpdateTask($userId, $projectId, $oldValue, $newValue);
        $this->projectActivityRepository->create($projectActivityCreateDto);
    }

    /**
     * @inheritDoc
     */
    public function createCompleteTask(int $userId, Uuid $projectId, string $taskBody): void
    {
        $projectActivityCreateDto = $this->projectActivityCreateDtoFactory->createCompleteTask($userId, $projectId, $taskBody);
        $this->projectActivityRepository->create($projectActivityCreateDto);
    }

    /**
     * @inheritDoc
     */
    public function createIncompleteTask(int $userId, Uuid $projectId, string $taskBody): void
    {
        $projectActivityCreateDto = $this->projectActivityCreateDtoFactory->createIncompleteTask($userId, $projectId, $taskBody);
        $this->projectActivityRepository->create($projectActivityCreateDto);
    }

    /**
     * @inheritDoc
     */
    public function createNewMember(int $userId, Uuid $projectId): void
    {
        $projectActivityCreateDto = $this->projectActivityCreateDtoFactory->createNewMember($userId, $projectId);
        $this->projectActivityRepository->create($projectActivityCreateDto);
    }

    /**
     * @inheritDoc
     */
    public function createDeleteMember(int $userId, Uuid $projectId): void
    {
        $projectActivityCreateDto = $this->projectActivityCreateDtoFactory->createDeleteMember($userId, $projectId);
        $this->projectActivityRepository->create($projectActivityCreateDto);
    }

    /**
     * @inheritDoc
     */
    public function findAllByProjectId(Uuid $projectId): array
    {
        return $this->projectActivityRepository->findAllByProjectId($projectId, $this->activitiesLimit);
    }
}
