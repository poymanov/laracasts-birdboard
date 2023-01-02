<?php

namespace App\Enums;

enum ProjectInviteStatusEnum: string
{
    case SENT = 'sent';

    case ACCEPTED = 'accepted';

    case REJECTED = 'rejected';
}
