<?php
namespace PhpStructureGenerator\Generator\FieldTypes;

use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpLiteral;
use PhpStructureGenerator\Generator\AbstractField;
use PhpStructureGenerator\Generator\FieldFactory;
use PhpStructureGenerator\Generator\NameHolder;
use PhpStructureGenerator\Generator\PhpHierarchy;
use PhpStructureGenerator\Generator\Settings;

/**
 * Class MapField
 *
 * @package PhpStructureGenerator\Generator\FieldTypes
 */
class MapField extends AbstractField
{
    /** @var NameHolder */
    private $valueType;

    public function __construct(array $options)
    {
        $this->valueType = new NameHolder($options['value_type']);

        parent::__construct($options);
    }


    /**
     * Generates the properties of a field on a class
     * @param ClassType $class
     */
    public function generateProperties(ClassType $class, Settings $settings)
    {

        $prop = $class->addProperty($this->getPropertyName());
        $prop->addComment("@var {$this->valueType->PascalCase()}[]");
        $prop->setVisibility('private');
    }


    /**
     * Generates the property/ies on a class
     * @param ClassType $class
     */
    public function generateGetters(ClassType $class, Settings $settings)
    {
        $method = $class->addMethod('get' . $this->name->PascalCase());
        $method->addComment("@return {$this->valueType->PascalCase()}[]");
        $method->setReturnType('array');
        $method->setVisibility('public');
        $method->addBody('return $this->?;', [$this->getPropertyName()]);
    }


    /**
     * Generates the property/ies on a class
     * @param Method $method
     * @param string $varName
     * @param Settings $settings
     */
    public function generateImport(Method $method, string $varName, Settings $settings)
    {
        $stmt = PhpHierarchy::create()
            ->if("\array_key_exists(?, ?)", $this->key, new PhpLiteral($varName))
            ->add('/** @var array $value */');

        if(in_array($this->valueType->originalName, FieldFactory::getPrimitiveTypes())){
            $stmt = $stmt->foreach('?[?] as $key => $value',new PhpLiteral($varName), $this->key)
                ->add('$this->?[$key] = $value;',
                    $this->getPropertyName()
                )
                ->close();
        } else {
            $stmt = $stmt->foreach('?[?] as $key => $value',new PhpLiteral($varName), $this->key)
                ->add('$field = new ?();',
                    new PhpLiteral($this->valueType->PascalCase())
                )
                ->add('$field->import($value);' )
                ->add('$this->?[$key] = $field;',
                    $this->getPropertyName()
                )
                ->close();

        }


        if (!$this->optional) {

            $stmt = $stmt->else();
            $stmt->add('throw new \ParseError("Could not find the ? argument");', $this->key);
        }

        $stmt = $stmt->close()
            ->print($settings);
        $method->addBody($stmt);

    }


}