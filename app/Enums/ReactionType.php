<?php

namespace App\Enums;

enum ReactionType: string
{
    //
    case Like = 'like';
    case Love = 'love';
    case Care = 'care';
    case Haha = 'haha';
    case Wow = 'wow';
    case Sad = 'sad';
    case Angry = 'angry';

    public function emoji(): string
    {
        return match($this) {
            self::Like => '👍',
            self::Love => '❤️',
            self::Care => '🤗',
            self::Haha => '😂',
            self::Wow => '😮',
            self::Sad => '😢',
            self::Angry => '😠',
        };

    }

    /**
     * Get Tailwind color class for the reaction type.
     */

    public function color(): string
    {
        return match($this) {
            self::Like => 'text-blue-500',
            self::Love => 'text-red-500',
            self::Care => 'text-yellow-500',
            self::Haha => 'text-yellow-400',
            self::Wow => 'text-purple-500',
            self::Sad => 'text-gray-500',
            self::Angry => 'text-orange-500',
        };
    }

    /**
     * Background color class for the reaction type.
     */

    public function bgColor(): string
    {
        return match($this) {
            self::Like => 'bg-blue-100 dark:bg-blue-900',
            self::Love => 'bg-red-100 dark:bg-red-900',
            self::Care => 'bg-yellow-100 dark:bg-yellow-900',
            self::Haha => 'bg-yellow-50 dark:bg-yellow-900',
            self::Wow => 'bg-purple-100 dark:bg-purple-900',
            self::Sad => 'bg-gray-100 dark:bg-gray-800',
            self::Angry => 'bg-orange-100 dark:bg-orange-900',
        };
    }

    public function label(): string
    {
        return ucfirst($this->value);
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

}
