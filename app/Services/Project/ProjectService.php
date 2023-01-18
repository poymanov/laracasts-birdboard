<?php

namespace App\Services\Project;

use App\Enums\CacheKeysEnum;
use App\Enums\ProjectActivityTypeEnum;
use App\Services\Project\Contracts\ProjectRepositoryContract;
use App\Services\Project\Contracts\ProjectServiceContract;
use App\Services\Project\Dtos\ProjectCreateDto;
use App\Services\Project\Dtos\ProjectDto;
use App\Services\Project\Dtos\ProjectUpdateDto;
use App\Services\ProjectActivity\Contracts\ProjectActivityServiceContract;
use Illuminate\Cache\Repository;
use Illuminate\Support\Facades\DB;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;
use Throwable;

class ProjectService implements ProjectServiceContract
{
    public function __construct(
        private readonly ProjectRepositoryContract $projectRepository,
        private readonly Repository $cacheService,
        private readonly ProjectActivityServiceContract $projectActivityService,
        private readonly array $cacheTags,
        private readonly int $cacheTtl
    ) {
    }

    /**
     * @inheritDoc
     */
    public function create(ProjectCreateDto $projectCreateDto): void
    {
        DB::beginTransaction();

        try {
            $projectId = $this->projectRepository->create($projectCreateDto);
            $this->projectActivityService->createCreateProject($projectCreateDto->ownerId, Uuid::make($projectId));

            DB::commit();

            $this->cacheService->tags($this->cacheTags)->flush();
        } catch (Throwable $exception) {
            DB::rollback();

            throw $exception;
        }
    }

    /**
     * @inheritDoc
     */
    public function update(Uuid $id, int $userId, ProjectUpdateDto $projectUpdateDto): void
    {
        DB::beginTransaction();

        try {
            $project = $this->findOneById($id);

            $this->projectRepository->update($id, $projectUpdateDto);
            $this->cacheService->tags($this->cacheTags)->flush();

            if ($project->title !== $projectUpdateDto->title) {
                $this->projectActivityService->createUpdateProject(
                    $userId,
                    $id,
                    ProjectActivityTypeEnum::UPDATE_PROJECT_TITLE->value,
                    $project->title,
                    $projectUpdateDto->title
                );
            }

            if ($project->description !== $projectUpdateDto->description) {
                $this->projectActivityService->createUpdateProject(
                    $userId,
                    $id,
                    ProjectActivityTypeEnum::UPDATE_PROJECT_DESCRIPTION->value,
                    $project->description,
                    $projectUpdateDto->description
                );
            }

            DB::commit();
        } catch (Throwable $exception) {
            DB::rollback();

            throw new $exception();
        }
    }

    /**
     * @inheritDoc
     */
    public function delete(Uuid $id): void
    {
        $this->projectRepository->delete($id);

        $this->cacheService->tags($this->cacheTags)->flush();
    }

    /**
     * @inheritDoc
     */
    public function isBelongsToUser(int $userId, Uuid $projectId): bool
    {
        return $this->projectRepository->isBelongsToUser($userId, $projectId);
    }

    /**
     * @inheritDoc
     */
    public function findAllByUserId(int $userId): array
    {
        return $this->cacheService
            ->tags($this->cacheTags)
            ->remember(CacheKeysEnum::USER_PROJECTS->value . $userId, $this->cacheTtl, function () use ($userId) {
                return $this->projectRepository->findAllByUserId($userId);
            });
    }

    /**
     * @inheritDoc
     */
    public function findOneById(Uuid $id): ProjectDto
    {
        return $this->projectRepository->findOneById($id);
    }

    /**
     * @inheritDoc
     */
    public function updateNotes(Uuid $id, int $userId, string $notes): void
    {
        DB::beginTransaction();

        try {
            $project = $this->findOneById($id);

            $this->projectRepository->updateNotes($id, $notes);
            $this->cacheService->tags($this->cacheTags)->flush();

            if ($project->notes !== $notes) {
                $this->projectActivityService->createUpdateProject(
                    $userId,
                    $id,
                    ProjectActivityTypeEnum::UPDATE_PROJECT_NOTES->value,
                    $project->notes,
                    $notes
                );
            }

            DB::commit();
        } catch (Throwable $exception) {
            DB::rollback();

            throw new $exception();
        }
    }
}
