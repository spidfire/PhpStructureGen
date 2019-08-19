<?php


namespace PhpStructureGenerator\Generator;


use ParseError;
use PhpStructureGenerator\Generator\FieldTypes\ArrayField;
use PhpStructureGenerator\Generator\FieldTypes\MapField;
use PhpStructureGenerator\Generator\FieldTypes\PrimitiveField;

class FieldFactory
{

    public static function createFromObject(array $field): AbstractField
    {
        $type = $field['type'] or die('Missing type');


        $primitiveTypes = self::getPrimitiveTypes();
        if (in_array($type, $primitiveTypes, true)){
            return new PrimitiveField($field);
        } elseif ($type === 'array'){
            return new ArrayField($field);
        } elseif ($type === 'map'){
            return new MapField($field);
        } else {
            throw new ParseError("Unknown type $type");
        }

    }

    /**
     * @return array
     */
    public static function getPrimitiveTypes(): array
    {
        return ['string', 'bool', 'int', 'float'];
    }
}