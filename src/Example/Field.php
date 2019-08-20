<?php
namespace PhpStructureGenerator\Example;


/**
 * Automatic generated datastructure
 */
class Field
{
    /** @var string */
    private $propertyName;

    /** @var string */
    private $propertyKey;

    /** @var string */
    private $propertyType;

    /** @var string */
    private $propertyKeyType;

    /** @var string */
    private $propertyValueType;

    /**
     * @param array $arrayData
     */
    public function import(array $arrayData)
    {
        if (\array_key_exists('name', $arrayData)) {
            $this->propertyName = $arrayData['name'];
        }
        if (\array_key_exists('key', $arrayData)) {
            $this->propertyKey = $arrayData['key'];
        }
        if (\array_key_exists('type', $arrayData)) {
            $this->propertyType = $arrayData['type'];
        }
        if (\array_key_exists('key_type', $arrayData)) {
            $this->propertyKeyType = $arrayData['key_type'];
        }
        if (\array_key_exists('value_type', $arrayData)) {
            $this->propertyValueType = $arrayData['value_type'];
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->propertyName;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->propertyKey;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->propertyType;
    }

    /**
     * @return string
     */
    public function getKeyType(): string
    {
        return $this->propertyKeyType;
    }

    /**
     * @return string
     */
    public function getValueType(): string
    {
        return $this->propertyValueType;
    }
}
