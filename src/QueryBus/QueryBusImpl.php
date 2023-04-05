<?php

namespace BBLDN\CQRSLaravel\QueryBus;

use LogicException;
use BBLDN\CQRS\QueryBus\QueryBus;
use Illuminate\Contracts\Container\Container;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;

class QueryBusImpl implements QueryBus
{
    /**
     * @param Container $container
     * @param QueryRegistry $queryRegistry
     */
    public function __construct(
        private readonly Container $container,
        private readonly QueryRegistry $queryRegistry
    )
    {
    }

    /**
     * @param object $query
     * @return mixed
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function execute(object $query): mixed
    {
        $queryClassName = get_class($query);
        if (false === $this->queryRegistry->has($queryClassName)) {
            throw new LogicException("Handler for $queryClassName not found");
        }

        /** @var string $queryHandlerClassName */
        $queryHandlerClassName = $this->queryRegistry->get($queryClassName);
        if (false === $this->container->has($queryHandlerClassName)) {
            throw new LogicException("Handler for $queryClassName not found");
        }

        /** @var callable $queryHandler */
        $queryHandler = $this->container->get($queryHandlerClassName);

        return call_user_func($queryHandler, $query);
    }
}
