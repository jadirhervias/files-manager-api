<?php

namespace FilesManager\Shared\Domain;

abstract class AggregateRoot
{
    abstract function toPrimitives(): array;
}
