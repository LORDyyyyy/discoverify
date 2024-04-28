<?php

declare(strict_types=1);

namespace Framework;

use ReflectionClass, ReflectionNamedType;
use Framework\Exceptions\ContainerException;

class Container
{
    private array $definitions = [];
    private array $resolved = [];

    /**
     * Add a new definition to the container
     *
     * @param array array of new definitions
     */
    public function addDefinitions(array $newDefinitions)
    {
        $this->definitions = [...$this->definitions, ...$newDefinitions];
    }


    /**
     * Resolves a class by instantiating it with its dependencies.
     *
     * @param string $className The fully qualified class name to resolve.
     * @return object The instantiated object of the resolved class.
     * @throws ContainerException If the class is not instantiable or if a dependency cannot be resolved.
     */
    public function resolve(string $className): object
    {
        $reflectionClass = new ReflectionClass($className);

        if (!$reflectionClass->isInstantiable()) {
            throw new ContainerException("Class {$className} is not instantiable.");
        }

        $constructor = $reflectionClass->getConstructor();

        if (!$constructor) {
            return new $className;
        }

        $params = $constructor->getParameters();

        if (count($params) === 0) {
            return new $className;
        }

        $dependencies = [];

        foreach ($params as $param) {
            $name = $param->getName();
            $type = $param->getType();

            if (!$type) {
                throw new ContainerException("Failed to resolve class {$className} because param {$name} is missing a type hint.");
            }

            if (!$type instanceof ReflectionNamedType || $type->isBuiltin()) {
                throw new ContainerException("Failed to resolve class {$className} because param {$name} has an invalid type hint.");
            }

            $dependencies[] = $this->get($type->getName());
        }

        return $reflectionClass->newInstanceArgs($dependencies);
    }

    /**
     * Get a class from the container,
     * if already instantiated, return the instance,
     * else, return a new instance
     *
     * @param string $id the class name to get
     * @return object the class instance
     */
    public function get(string $id)
    {
        if (!array_key_exists($id, $this->definitions)) {
            throw new ContainerException("Class {$id} does not exist in the container");
        }

        if (array_key_exists($id, $this->resolved)) {
            return $this->resolved[$id];
        }

        $factory = $this->definitions[$id];
        $dependencies = $factory($this);

        $this->resolved[$id] = $dependencies;

        return $dependencies;
    }
}
