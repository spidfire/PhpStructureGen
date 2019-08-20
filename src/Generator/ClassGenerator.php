<?php


namespace PhpStructureGenerator\Generator;


use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\PsrPrinter;

class ClassGenerator
{
    /** @var Method */
    private $importHolder;
    /** @var ClassType */
    private $classHolder;
    /** @var Settings */
    private $settings;

    private const IMPORT_VARIABLE = 'arrayData';


    /**
     * ClassGenerator constructor.
     * @param NameHolder $class
     * @param Settings $settings
     */
    public function __construct(
        NameHolder $class,
        Settings $settings
    )
    {

        $this->settings = $settings;
        $this->classHolder = new ClassType($class->PascalCase(), $settings->getNamespace());

        $this->classHolder
            ->addComment('Automatic generated datastructure');


        $importFunction = $this->classHolder->addMethod('import');
        $param = $importFunction->addParameter(static::IMPORT_VARIABLE);
        $param->setTypeHint('array');
        $importFunction->setVisibility('public');
        $importFunction->addComment('@param array $'.static::IMPORT_VARIABLE);
        $this->importHolder = $importFunction;

    }

    /**
     * @param AbstractField $field
     */
    public function addField(AbstractField $field): void
    {
        $field->generateGetters($this->classHolder, $this->settings);
        $field->generateProperties($this->classHolder, $this->settings);
        $field->generateImport($this->importHolder, '$' . static::IMPORT_VARIABLE, $this->settings);

    }

    /**
     * @return string
     */
    public function export(): string
    {
        $printer = new PsrPrinter;

        return '<?php' . PHP_EOL . $this->settings->getNamespace() . PHP_EOL . $printer->printClass($this->classHolder);

    }
}