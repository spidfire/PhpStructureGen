<?php


namespace PhpStructureGenerator\Generator;

use \Nette\PhpGenerator\Helpers;
class PhpHierarchy
{
    /** @var int */
    private $depth = 0;

    /** @var array */
    private $list = [];

    /** @var PhpHierarchy|null  */
    private $parent = null;

    /**
     * PhpHierarchy constructor.
     * @param int $depth
     * @param PhpHierarchy|null $parent
     */
    private function __construct(int $depth, ?PhpHierarchy $parent)
    {
        $this->depth = $depth;
        $this->parent = $parent;
    }


    public static function create(): PhpHierarchy{
        return new PhpHierarchy(0, null);
    }

    function add(string $line, ...$args): PhpHierarchy
    {
        $this->list[] = Helpers::format($line, ...$args);

        return $this;

    }


    function struct(string $type, string $arguments, ...$args): PhpHierarchy
    {

        $stuct = new PhpHierarchy($this->depth+1, $this);
        $this->list[] = Helpers::format("$type ($arguments) {", ...$args);
        $this->list[] = $stuct;

        return $stuct;

    }
    function else(string $arguments = '', ...$args): PhpHierarchy
    {
        $stuct = new PhpHierarchy($this->depth, $this->parent);
        if (empty($arguments)) {
            $this->parent->list[] = Helpers::format("} else {", ...$args);
        } else {
            $this->parent->list[] = Helpers::format("} elseif ($arguments) {", ...$args);
        }
        $this->parent->list[] = $stuct;

        return $stuct;

    }


    function if(string $arguments, ...$args): PhpHierarchy
    {
        return $this->struct('if', $arguments, ...$args);
    }

    function foreach(string $arguments, ...$args): PhpHierarchy
    {
        return $this->struct('foreach', $arguments, ...$args);
    }

    function close():?PhpHierarchy{
        $this->parent->list[] = '}';
        return $this->parent;
    }

    protected function getGeneratedLines(Settings $settings):array{
        $out = [];
        foreach ($this->list as $line){
            if($line instanceof PhpHierarchy){
                foreach ($line->getGeneratedLines($settings) as $l){
                    $out[] = $l;
                }
            } else {
                $out[] = str_repeat($settings->indent, $this->depth). $line;
            }
        }
        return $out;

    }


    function print(Settings $settings){
        return implode(PHP_EOL, $this->getGeneratedLines($settings));

    }

}