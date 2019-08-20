<?php
namespace PhpStructureGenerator\Example;


/**
 * Automatic generated datastructure
 */
class Structure
{
    /** @var Field[] */
    private $propertyFields;

    /**
     * @param array $arrayData
     */
    public function import(array $arrayData)
    {
        if (\array_key_exists('fields', $arrayData)) {
            /** @var array $value */
            foreach ($arrayData['fields'] as $value) {
                $field = new Field();
                $field->import($value);
                $this->propertyFields[] = $field;
            }
        } else {
            throw new \ParseError("Could not find the 'fields' argument");
        }
    }

    /**
     * @return Field[]
     */
    public function getFields(): array
    {
        return $this->propertyFields;
    }
}
