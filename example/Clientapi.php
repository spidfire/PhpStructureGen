<?php
/**
 * Automatic generated datastructure
 */
class Clientapi
{
    /** @var string */
    private $propertytarget;

    /** @var string */
    private $propertynamespace;

    /** @var map */
    private $propertystructures;

    public function import(array $arrayData)
    {
        if ($arrayData['target'] !== null) {
            $this->propertytarget = $arrayData['target'];
        } else {
            throw new \RuntimeException("Missing the key 'target'");
        }
        if ($arrayData['namespace'] !== null) {
            $this->propertynamespace = $arrayData['namespace'];
        } else {
            throw new \RuntimeException("Missing the key 'namespace'");
        }
        if ($arrayData['structures'] !== null) {
            foreach ($arrayData['structures'] as $key => $line) {
                $this->propertystructures[$key] = $line;
            }
        } else {
            throw new \RuntimeException("Missing the key 'structures'");
        }
    }

    public function getTarget()
    {
        return $this->propertytarget;
    }

    public function getNamespace()
    {
        return $this->propertynamespace;
    }

    public function getStructures()
    {
        return $this->propertystructures;
    }
}
