<?php


namespace PhpStructureGenerator\Generator;


class NameHolder
{
    /** @var string */
    var $originalName;

    /**
     * NameHolder constructor.
     * @param string $originalName
     */
    public function __construct(string $originalName)
    {
        $this->originalName = $originalName;
    }


    public function getOriginal():string{
        return $this->originalName;
    }

    public function snake_case()
    {
        $input = $this->originalName;
        $out = [];
        for ($i = 0, $iMax = strlen($input); $i < $iMax; $i++) {
            if (ctype_upper($input[$i])) {
                $out[] = '_';
                $out[] = strtolower($input[$i]);
            } elseif ($input[$i] === '_' || $input[$i] === '-') {
                $out[] = '_';
            } else {
                $out[] = $input[$i];
            }
        }
        return preg_replace('/_+/', '_', implode('', $out));


    }


    /** camelCase */
    public function camelCase(): string
    {
        return $this->phpCaseFunction($this->originalName, false);
    }


    /** PascalCase
     * @return string|
     */
    public function PascalCase(): string
    {
        return $this->phpCaseFunction($this->originalName, true);
    }


    private function phpCaseFunction(string $input, bool $firstUpper = true)
    {
        $out = [];
        $nextUpper = $firstUpper;
        for ($i = 0, $iMax = strlen($input); $i < $iMax; $i++) {
            if ($input[$i] === '_' || $input[$i] === '-' || trim($input[$i]) === '') {
                $nextUpper = true;
            } else {
                if ($nextUpper) {
                    $nextUpper = false;
                    $out[] = strtoupper($input[$i]);
                } else {
                    $out[] = strtolower($input[$i]);
                }
            }

        }
        return implode('', $out);


    }


}