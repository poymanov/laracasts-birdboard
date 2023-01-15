<?php

namespace App\Services\ProjectActivity\Contracts;

use App\Services\ProjectActivity\Dtos\ProjectActivityDto;
use App\Services\ProjectActivity\Exceptions\ProjectActivityCreateFailedException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface ProjectActivityServiceContract
{
    /**
     * Создание активности "Создан проект"
     *
     * @param int  $userId
     * @param Uuid $projectId
     *
     * @return void
     * @throws ProjectActivityCreateFailedException
     */
    public function createCreateProject(int $userId, Uuid $projectId): void;

    /**
     * Создание активности "Проект обновлён"
     *
     * @param int         $userId
     * @param Uuid        $projectId
     * @param string      $type
     * @param string|null $oldValue
     * @param string      $newValue
     *
     * @return void
     * @throws ProjectActivityCreateFailedException
     */
    public function createUpdateProject(int $userId, Uuid $projectId, string $type, ?string $oldValue, string $newValue): void;

    /**
     * Создание активности "Создание задачи"
     *
     * @param int    $userId
     * @param Uuid   $projectId
     * @param string $newValue
     *
     * @return void
     * @throws ProjectActivityCreateFailedException
     */
    public function createCreateTask(int $userId, Uuid $projectId, string $newValue): void;

    /**
     * Создание активности "Обновление задачи"
     *
     * @param int    $userId
     * @param Uuid   $projectId
     * @param string $oldValue
     * @param string $newValue
     *
     * @return void
     * @throws ProjectActivityCreateFailedException
     */
    public function createUpdateTask(int $userId, Uuid $projectId, string $oldValue, string $newValue): void;

    /**
     * Создание активности "Завершение задачи"
     *
     * @param int    $userId
     * @param Uuid   $projectId
     * @param string $taskBody
     *
     * @return void
     * @throws ProjectActivityCreateFailedException
     */
    public function createCompleteTask(int $userId, Uuid $projectId, string $taskBody): void;

    /**
     * Создание активности "Отмена завершения задачи"
     *
     * @param int    $userId
     * @param Uuid   $projectId
     * @param string $taskBody
     *
     * @return void
     * @throws ProjectActivityCreateFailedException
     */
    public function createIncompleteTask(int $userId, Uuid $projectId, string $taskBody): void;

    /**
     * Создание активности "Добавление нового участника"
     *
     * @param int  $userId
     * @param Uuid $projectId
     *
     * @return void
     * @throws ProjectActivityCreateFailedException
     */
    public function createNewMember(int $userId, Uuid $projectId): void;

    /**
     * Создание активности "Удаление участника"
     *
     * @param int  $userId
     * @param Uuid $projectId
     *
     * @return void
     * @throws ProjectActivityCreateFailedException
     */
    public function createDeleteMember(int $userId, Uuid $projectId): void;

    /**
     * Получение списка активностей по ID проекта
     *
     * @param Uuid $projectId
     *
     * @return ProjectActivityDto[]
     */
    public function findAllByProjectId(Uuid $projectId): array;
}
