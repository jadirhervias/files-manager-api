<?php

namespace FilesManager\File\Domain;

enum FileStatuses: string
{
    case VISIBLE = 'visible';
    case HIDDEN = 'hidden';

    static public function values(): array
    {
        return array_map(fn(FileStatuses $status) => $status->value, self::cases());
    }

    static public function names(): array
    {
        return array_map(fn(FileStatuses $status) => $status->name, self::cases());
    }

    public function is(FileStatuses $status): bool
    {
        return $this->value === $status->value;
    }
}
