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
        if (isset($this->casts[$name])) {
            $value = $this->castValue($value, $this->casts[$name]);
        } elseif (is_object($value)) {
            $value = $this->castObjectProperties($value);
        }
    
        $this->properties->{$name} = $value;
    }

    protected function setAttributes($data): void
    {
        $this->properties = new \stdClass();

        foreach ($data as $key => $value) {
            $this->__set($key, $value);
        }
    }

    protected function castObjectProperties(object $object): object
    {
        $result = [];
        foreach ($object as $key => $value) {
            if (isset($this->casts[$key])) {
                $casted = $this->castValue($value, $this->casts[$key]);
                $result[$key] = $casted;
            } elseif (is_object($value)) {
                $result[$key] = $this->castObjectProperties($value);
            } else {
                $result[$key] = $value;
            }
        }
        return (object) $result;
    }

    protected function castValue($value, $cast)
    {
        if (is_string($cast) && is_subclass_of($cast, BaseModel::class)) {
            return new $cast($value);
        }
    
        if (
            is_array($cast) &&
            isset($cast['type']) &&
            is_subclass_of($cast['type'], BaseModel::class)
        ) {
            $type = $cast['type'];
    
            if (!empty($cast['many']) && is_object($value)) {
                $result = [];
                foreach ($value as $key => $item) {
                    $result[$key] = new $type($item);
                }
                return (object) $result;
            }
    
            return new $type($value);
        }

        return $value;
    }
}
