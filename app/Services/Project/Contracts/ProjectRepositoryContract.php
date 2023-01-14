<?php

namespace App\Services\Project\Contracts;

use App\Services\Project\Dtos\ProjectCreateDto;
use App\Services\Project\Dtos\ProjectDto;
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
     * @return string
     * @throws ProjectCreateFailedException
     */
    public function create(ProjectCreateDto $projectCreateDto): string;

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

    /**
     * Получение списка проектов, где пользователь является владельцем или участником
     *
     * @return ProjectDto[]
     */
    public function findAllByUserId(int $userId): array;

    /**
     * Получение DTO объекта по id
     *
     * @param Uuid $id
     *
     * @return ProjectDto
     * @throws ProjectNotFoundException
     */
    public function findOneById(Uuid $id): ProjectDto;

    /**
     * Обновление заметок проекта
     *
     * @param Uuid   $id
     * @param string $notes
     *
     * @return void
     * @throws ProjectNotFoundException
     * @throws ProjectUpdateFailedException
     */
    public function updateNotes(Uuid $id, string $notes): void;
}
