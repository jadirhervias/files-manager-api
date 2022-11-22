<?php

namespace FilesManager\Shared\Domain;

final class Utils
{
    public static function toSnakeCase(string $text): string
    {
        return ctype_lower($text)
            ? $text
            : strtolower(preg_replace('/([^A-Z\s])([A-Z])/', "$1_$2", $text));
    }

    public static function hasTrait($objectOrClass, string $trait): bool
    {
        return in_array($trait, class_uses($objectOrClass));
    }
}
