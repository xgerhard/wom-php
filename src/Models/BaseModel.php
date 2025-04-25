<?php

namespace WOM\Models;

abstract class BaseModel
{
    protected \stdClass $properties;
    protected array $casts = [];

    public function __construct(\stdClass $data)
    {
        $this->setAttributes($data);
    }

    public function __get(string $name)
    {
        return $this->properties->{$name} ?? null;
    }

    public function __set(string $name, $value): void
    {
        $this->properties->{$name} = $this->resolvePropertyValue($name, $value);
    }

    public function __isset(string $name): bool
    {
        return isset($this->properties->{$name});
    }

    protected function setAttributes($data): void
    {
        $this->properties = new \stdClass();

        if (!$this->isIterableLike($data)) {
            return;
        }

        foreach ($data as $key => $value) {
            $this->__set($key, $value);
        }
    }

    protected function resolvePropertyValue(string $key, $value)
    {
        if (isset($this->casts[$key])) {
            return $this->castValue($value, $this->casts[$key]);
        }

        if (is_object($value)) {
            return $this->castObjectProperties($value);
        }

        return $value;
    }

    protected function castValue($value, $cast)
    {
        if ($value === null) {
            return null;
        }

        if (is_string($cast) && is_subclass_of($cast, BaseModel::class)) {
            return new $cast($value);
        }

        if (
            is_array($cast) &&
            isset($cast['type']) &&
            is_subclass_of($cast['type'], BaseModel::class)
        ) {
            $type = $cast['type'];

            if (!empty($cast['many']) && $this->isIterableLike($value)) {
                return $this->castManyToModel($value, $type);
            }

            return new $type($value);
        }

        return $value;
    }

    protected function castObjectProperties(object $object): object
    {
        $result = [];

        foreach ($object as $key => $value) {
            $result[$key] = $this->resolvePropertyValue($key, $value);
        }

        return (object) $result;
    }

    protected function castManyToModel($items, string $type): object
    {
        $result = [];

        foreach ($items as $key => $item) {
            $result[$key] = new $type($item);
        }

        return (object) $result;
    }

    protected function isIterableLike($value): bool
    {
        return is_array($value) || is_object($value);
    }
}
