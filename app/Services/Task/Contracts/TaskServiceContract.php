<?php

namespace App\Services\Task\Contracts;

use App\Services\Task\Dtos\TaskCreateDto;
use App\Services\Task\Dtos\TaskUpdateDto;
use App\Services\Task\Exceptions\TaskCreateFailedException;
use App\Services\Task\Exceptions\TaskNotBelongsToProject;
use App\Services\Task\Exceptions\TaskUpdateFailedException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface TaskServiceContract
{
    /**
     * Создание задачи
     *
     * @param int           $userId
     * @param TaskCreateDto $taskCreateDto
     *
     * @return void
     * @throws TaskCreateFailedException
     */
    public function create(int $userId, TaskCreateDto $taskCreateDto): void;

    /**
     * Создание задачи
     *
     * @param Uuid          $id
     * @param TaskUpdateDto $taskUpdateDto
     *
     * @return void
     * @throws TaskUpdateFailedException
     * @throws TaskNotBelongsToProject
     */
    public function update(Uuid $id, int $userId, TaskUpdateDto $taskUpdateDto): void;

    /**
     * Получение списка задач по ID проекта
     *
     * @param Uuid $projectId
     *
     * @return array
     */
    public function findAllByProjectId(Uuid $projectId): array;
}
