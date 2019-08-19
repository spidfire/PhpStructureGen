<?php


namespace PhpStructureGenerator\Generator;


use Nette\PhpGenerator\PhpNamespace;

class Settings
{
    public $indent = '    ';

    /** @var PhpNamespace */
    private $namespace;

    /**
     * @return PhpNamespace
     */
    public function getNamespace(): PhpNamespace
    {
        return $this->namespace;
    }

    /**
     * @param PhpNamespace $namespace
     */
    public function setNamespace(PhpNamespace $namespace): void
    {
        $this->namespace = $namespace;
    }


}