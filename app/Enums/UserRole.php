<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Contributor = 'contributor';
    case Collector = 'collector';
}
