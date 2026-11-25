<?php

namespace App\Enums;

/**
 * Distingue clairement la nature de ma participation (cahier des charges, section 3.3).
 */
enum Involvement: string
{
    case Personal = 'personal';
    case Team = 'team';
    case Maintenance = 'maintenance';
}
