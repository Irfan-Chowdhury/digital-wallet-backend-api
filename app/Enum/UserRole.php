<?php

namespace App\Enum;

enum UserRole : string
{
    case SUPER_ADMIN = 'SUPER_ADMIN';
    case ADMIN = 'ADMIN';
    case USER = 'USER';
    case AGENT = 'AGENT';
}

