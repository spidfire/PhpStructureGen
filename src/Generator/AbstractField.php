<?php


namespace PhpStructureGenerator\Generator;


use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpLiteral;

class AbstractField
{
    /** @var NameHolder */
    protected $name;

    /** @var string */
    protected $key;

    /** @var string */
    protected $type;

    /** @var boolean */
    protected $optional;

    /** @var array */
    protected $options;

    /**
     * AbstractField constructor.
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->options = $options;
        $this->name = new NameHolder($options['name']);
        $this->type = $options['type'] or die('Missing type name');
        $this->optional = isset($options['optional']) ? $options['optional'] === true : false;
        $this->key = !empty($options['key']) ? $options['key'] : $options['name'];
    }


    protected function getPropertyName(): string
    {
        return 'property' . $this->name->PascalCase();
    }

    /**
     * Generates the properties of a field on a class
     * @param ClassType $class
     */
    public function generateProperties(ClassType $class, Settings $settings)
    {

        $prop = $class->addProperty($this->getPropertyName());
        $prop->addComment("@var {$this->type}");
        $prop->setVisibility('private');
    }


    /**
     * Generates the property/ies on a class
     * @param ClassType $class
     */
    public function generateGetters(ClassType $class, Settings $settings)
    {
        $method = $class->addMethod('get' . $this->name->PascalCase());
        $method->addComment("@return {$this->type}");
        $method->setReturnType($this->type);
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
        $php = PhpHierarchy::create()
            ->struct('if', "\array_key_exists(?, ?)", $this->key, new PhpLiteral($varName))
                ->add('$this->? = ?[?];', $this->getPropertyName(), new PhpLiteral($varName),  $this->key)
            ->close()
            ->print($settings);
        $method->addBody($php);

    }


}