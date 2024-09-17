<?php

namespace app\Enums;

enum TodoStatus: string
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function implode(string $separator = ', '): string
    {
        return implode($separator, self::values());
    }
}
