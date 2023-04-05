<?php

namespace BBLDN\CQRSLaravel\QueryBus;

use BBLDN\CQRS\QueryBus\Query;

class QueryRegistry
{
    /**
     * @param array<class-string<Query>, class-string> $queryClassMap
     */
    public function __construct(
        private readonly array $queryClassMap
    )
    {
    }

    /**
     * @return array<class-string<Query>, class-string>
     */
    public function getAll(): array
    {
        return $this->queryClassMap;
    }

    /**
     * @param class-string $queryClassName
     * @return string|null
     */
    public function get(string $queryClassName): string|null
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
