<?php

namespace BBLDN\CQRSLaravel\CommandBus;

class CommandRegistry
{
    /**
     * @var string[]
     *
     * @psalm-var array<class-string, class-string>
     */
    private array $commandClassMap;

    /**
     * @param string[] $commandClassMap
     *
     * @psalm-param array<class-string, class-string> $commandClassMap
     */
    public function __construct(array $commandClassMap)
    {
        $this->commandClassMap = $commandClassMap;
    }

    /**
     * @return string[]
     *
     * @psalm-return array<class-string, class-string>
     */
    public function getAll(): array
    {
        return $this->commandClassMap;
    }

    /**
     * @param string $commandClassName
     * @return string|null
     *
     * @psalm-param class-string $commandClassName
     */
    public function get(string $commandClassName): ?string
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