<?php

namespace App\Services\Task\Contracts;

use App\Services\Task\Dtos\TaskCreateDto;
use App\Services\Task\Dtos\TaskUpdateDto;
use App\Services\Task\Exceptions\TaskCreateFailedException;
use App\Services\Task\Exceptions\TaskNotFoundException;
use App\Services\Task\Exceptions\TaskUpdateFailedException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface TaskRepositoryContract
{
    /**
     * Создание задачи
     *
     * @param TaskCreateDto $taskCreateDto
     *
     * @return void
     * @throws TaskCreateFailedException
     */
    public function create(TaskCreateDto $taskCreateDto): void;

    /**
     * Изменение задачи
     *
     * @param Uuid          $id
     * @param TaskUpdateDto $taskUpdateDto
     *
     * @return void
     * @throws TaskNotFoundException
     * @throws TaskUpdateFailedException
     */
    public function update(Uuid $id, TaskUpdateDto $taskUpdateDto): void;

    /**
     * Принадлежит ли задачу проекту
     *
     * @param Uuid $taskId
     * @param Uuid $projectId
     *
     * @return bool
     */
    public function isBelongsToProject(Uuid $taskId, Uuid $projectId): bool;
}
