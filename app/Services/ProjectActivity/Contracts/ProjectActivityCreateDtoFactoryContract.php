<?php

namespace App\Services\ProjectActivity\Contracts;

use App\Services\ProjectActivity\Dtos\ProjectActivityCreateDto;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface ProjectActivityCreateDtoFactoryContract
{
    /**
     * Создание активности типа "Создание проекта"
     *
     * @param int  $userId
     * @param Uuid $projectId
     *
     * @return ProjectActivityCreateDto
     */
    public function createTypeCreateProject(int $userId, Uuid $projectId): ProjectActivityCreateDto;

    /**
     * Создание активности типа "Обновление проекта"
     *
     * @param int         $userId
     * @param Uuid        $projectId
     * @param string      $type
     * @param string|null $oldValue
     * @param string      $newValue
     *
     * @return ProjectActivityCreateDto
     */
    public function createTypeUpdateProject(int $userId, Uuid $projectId, string $type, ?string $oldValue, string $newValue): ProjectActivityCreateDto;

    /**
     * Создание активности типа "Создание задачи"
     *
     * @param int    $userId
     * @param Uuid   $projectId
     * @param string $newValue
     *
     * @return ProjectActivityCreateDto
     */
    public function createTypeCreateTask(int $userId, Uuid $projectId, string $newValue): ProjectActivityCreateDto;

    /**
     * Создание активности типа "Обновление задачи"
     *
     * @param int    $userId
     * @param Uuid   $projectId
     * @param string $oldValue
     * @param string $newValue
     *
     * @return ProjectActivityCreateDto
     */
    public function createUpdateTask(int $userId, Uuid $projectId, string $oldValue, string $newValue): ProjectActivityCreateDto;

    /**
     * Создание активности типа "Завершение задачи"
     *
     * @param int    $userId
     * @param Uuid   $projectId
     * @param string $taskBody
     *
     * @return ProjectActivityCreateDto
     */
    public function createCompleteTask(int $userId, Uuid $projectId, string $taskBody): ProjectActivityCreateDto;

    /**
     * Создание активности типа "Отмена завершения задачи"
     *
     * @param int    $userId
     * @param Uuid   $projectId
     * @param string $taskBody
     *
     * @return ProjectActivityCreateDto
     */
    public function createIncompleteTask(int $userId, Uuid $projectId, string $taskBody): ProjectActivityCreateDto;

    /**
     * Создание активности типа "Добавление нового участника"
     *
     * @param int  $userId
     * @param Uuid $projectId
     *
     * @return ProjectActivityCreateDto
     */
    public function createNewMember(int $userId, Uuid $projectId): ProjectActivityCreateDto;

    /**
     * Создание активности типа "Удаление участника"
     *
     * @param int  $userId
     * @param Uuid $projectId
     *
     * @return ProjectActivityCreateDto
     */
    public function createDeleteMember(int $userId, Uuid $projectId): ProjectActivityCreateDto;
}
