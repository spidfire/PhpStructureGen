<?php
/**
 * Automatic generated datastructure
 */
class Structure
{
    /** @var array */
    private $propertyfields;

    public function import(array $arrayData)
    {
        if ($arrayData['fields'] !== null) {
        } else {
            throw new \RuntimeException("Missing the key 'fields'");
        }
    }

    public function getFields()
    {
        return $this->propertyfields;
    }
}
