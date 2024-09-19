<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Contributor = 'contributor';
    case Collector = 'collector';

    public function isAdminOrContributor(): bool
    {
        return in_array($this, [UserRole::Admin, UserRole::Contributor]);
    }
}
