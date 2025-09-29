<?php

namespace App\Enums;

enum AppointmentStatusEnum: string
{
    case CANCELLED = 'cancelled';
    case SCHEDULED = 'scheduled';
    case FINALIZED = 'finalized';
}
