<?php

namespace App\Services\ProjectActivity\Contracts;

use App\Services\ProjectActivity\Dtos\ProjectActivityCreateDto;
use App\Services\ProjectActivity\Exceptions\ProjectActivityCreateFailedException;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface ProjectActivityRepositoryContract
{
    /**
     * Создание активности по проекту
     *
     * @param ProjectActivityCreateDto $projectActivityCreateDto
     *
     * @return void
     * @throws ProjectActivityCreateFailedException
     */
    public function create(ProjectActivityCreateDto $projectActivityCreateDto): void;

    /**
     * Получение списка активностей по ID проекта
     *
     * @param Uuid $projectId
     * @param int  $limit
     *
     * @return array
     */
    public function findAllByProjectId(Uuid $projectId, int $limit): array;
}
