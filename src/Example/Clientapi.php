<?php
namespace PhpStructureGenerator\Example;


/**
 * Automatic generated datastructure
 */
class Clientapi
{
    /** @var string */
    private $propertyTarget;

    /** @var string */
    private $propertyNamespace;

    /** @var String[] */
    private $propertyMiddleware;

    /** @var String[] */
    private $propertySettings;

    /** @var Structure[] */
    private $propertyStructures;

    public function import(array $arrayData)
    {
        if (array_key_exists('target', $arrayData)) {
            $this->propertyTarget = $arrayData['target'];
        }
        if (array_key_exists('namespace', $arrayData)) {
            $this->propertyNamespace = $arrayData['namespace'];
        }
        if (array_key_exists('middleware', $arrayData)) {
            foreach ($arrayData['middleware'] as $value) {
                $this->propertyMiddleware[] = $value;
            }
        } else {
            throw new \ParseError("Could not find the 'middleware' argument");
        }
        if (array_key_exists('settings', $arrayData)) {
            foreach ($arrayData['settings'] as $key => $value) {
                $this->propertySettings[$key] = $value;
            }
        } else {
            throw new \ParseError("Could not find the 'settings' argument");
        }
        if (array_key_exists('structures', $arrayData)) {
            foreach ($arrayData['structures'] as $key => $value) {
                $field = new Structure();
                $field->import($value);
                $this->propertyStructures[$key] = $field;
            }
        } else {
            throw new \ParseError("Could not find the 'structures' argument");
        }
    }

    /**
     * @return string
     */
    public function getTarget(): string
    {
        return $this->propertyTarget;
    }

    /**
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->propertyNamespace;
    }

    /**
     * @return String[]
     */
    public function getMiddleware(): array
    {
        return $this->propertyMiddleware;
    }

    /**
     * @return String[]
     */
    public function getSettings(): map
    {
        return $this->propertySettings;
    }

    /**
     * @return Structure[]
     */
    public function getStructures(): map
    {
        return $this->propertyStructures;
    }
}
