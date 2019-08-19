<?php
/**
 * Automatic generated datastructure
 */
class Field
{
    /** @var string */
    private $propertyname;

    /** @var string */
    private $propertykey;

    /** @var string */
    private $propertytype;

    /** @var string */
    private $propertykeyType;

    /** @var string */
    private $propertyvalueType;

    public function import(array $arrayData)
    {
        if ($arrayData['name'] !== null) {
            $this->propertyname = $arrayData['name'];
        } else {
            throw new \RuntimeException("Missing the key 'name'");
        }
        if ($arrayData['key'] !== null) {
            $this->propertykey = $arrayData['key'];
        }
        if ($arrayData['type'] !== null) {
            $this->propertytype = $arrayData['type'];
        } else {
            throw new \RuntimeException("Missing the key 'type'");
        }
        if ($arrayData['key_type'] !== null) {
            $this->propertykeyType = $arrayData['key_type'];
        }
        if ($arrayData['value_type'] !== null) {
            $this->propertyvalueType = $arrayData['value_type'];
        }
    }

    public function getName()
    {
        return $this->propertyname;
    }

    public function getKey()
    {
        return $this->propertykey;
    }

    public function getType()
    {
        return $this->propertytype;
    }

    public function getKeyType()
    {
        return $this->propertykeyType;
    }

    public function getValueType()
    {
        return $this->propertyvalueType;
    }
}
