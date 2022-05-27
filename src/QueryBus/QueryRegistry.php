<?php

namespace BBLDN\CQRSLaravel\QueryBus;

class QueryRegistry
{
    /**
     * @var string[]
     *
     * @psalm-var array<class-string, class-string>
     */
    private array $queryClassMap;

    /**
     * @param string[] $queryClassMap
     *
     * @psalm-param array<class-string, class-string> $queryClassMap
     */
    public function __construct(array $queryClassMap)
    {
        $this->queryClassMap = $queryClassMap;
    }

    /**
     * @return string[]
     *
     * @psalm-return array<class-string, class-string>
     */
    public function getAll(): array
    {
        return $this->queryClassMap;
    }

    /**
     * @param string $queryClassName
     * @return string|null
     *
     * @psalm-param class-string $queryClassName
     */
    public function get(string $queryClassName): ?string
    {
        return $this->queryClassMap[$queryClassName] ?? null;
    }

    /**
     * @param string $queryClassName
     * @return bool
     */
    public function has(string $queryClassName): bool
    {
        return true === key_exists($queryClassName, $this->queryClassMap);
    }
}