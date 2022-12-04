<?php

namespace App\Services\Project\Contracts;

use App\Services\Project\Dtos\ProjectCreateDto;
use App\Services\Project\Dtos\ProjectUpdateDto;
use App\Services\Project\Exceptions\ProjectCreateFailedException;
use App\Services\Project\Exceptions\ProjectDeleteFailedException;
use App\Services\Project\Exceptions\ProjectNotFoundException;
use App\Services\Project\Exceptions\ProjectUpdateFailedException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface ProjectRepositoryContract
{
    /**
     * @param ProjectCreateDto $projectCreateDto
     *
     * @return void
     * @throws ProjectCreateFailedException
     */
    public function create(ProjectCreateDto $projectCreateDto): void;

    /**
     * Обновление проекта
     *
     * @param Uuid             $id
     * @param ProjectUpdateDto $projectUpdateDto
     *
     * @return void
     * @throws ProjectNotFoundException
     * @throws ProjectUpdateFailedException
     */
    public function update(Uuid $id, ProjectUpdateDto $projectUpdateDto): void;

    /**
     * Удаление проекта
     *
     * @param Uuid $id
     *
     * @return void
     * @throws ProjectDeleteFailedException
     * @throws ProjectNotFoundException
     */
    public function delete(Uuid $id): void;

    /**
     * Принадлежит ли проект пользователю
     *
     * @param int  $userId
     * @param Uuid $projectId
     *
     * @return bool
     */
    public function isBelongsToUser(int $userId, Uuid $projectId): bool;
}
