<?php

namespace BBLDN\CQRSLaravel\CommandBus;

use BBLDN\CQRS\CommandBus\Command;

class CommandRegistry
{
    /**
     * @param array<class-string<Command>, class-string> $commandClassMap
     */
    public function __construct(
        private readonly array $commandClassMap
    )
    {
    }

    /**
     * @return array<class-string<Command>, class-string>
     */
    public function getAll(): array
    {
        return $this->commandClassMap;
    }

    /**
     * @param class-string $commandClassName
     * @return string|null
     */
    public function get(string $commandClassName): string|null
    {
        return $this->commandClassMap[$commandClassName] ?? null;
    }

    /**
     * @param string $commandClassName
     * @return bool
     */
    public function has(string $commandClassName): bool
    {
        return true === key_exists($commandClassName, $this->commandClassMap);
    }
}