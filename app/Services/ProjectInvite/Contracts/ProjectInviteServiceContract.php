<?php

namespace App\Services\ProjectInvite\Contracts;

use App\Services\Project\Exceptions\ProjectNotFoundException;
use App\Services\ProjectInvite\Dtos\ProjectInviteDto;
use App\Services\ProjectInvite\Exceptions\ProjectInviteAlreadyException;
use App\Services\ProjectInvite\Exceptions\ProjectInviteCreateFailedException;
use App\Services\ProjectInvite\Exceptions\ProjectInviteSelfCreateException;
use App\Services\User\Exceptions\UserNotFoundByEmailException;
use Exception;
use MichaelRubel\ValueObjects\Collection\Complex\Email;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

interface ProjectInviteServiceContract
{
    /**
     * Создание приглашения пользователя в проект
     *
     * @param Uuid $projectId
     * @param Email $email
     *
     * @return void
     * @throws ProjectInviteCreateFailedException
     * @throws ProjectInviteAlreadyException
     * @throws ProjectInviteSelfCreateException
     * @throws ProjectNotFoundException
     * @throws UserNotFoundByEmailException
     */
    public function create(Uuid $projectId, Email $email): void;

    /**
     * Получение новых приглашения пользователя
     *
     * @param int $userId
     *
     * @return ProjectInviteDto[]
     * @throws Exception
     */
    public function findAllSentByUserId(int $userId): array;
}
