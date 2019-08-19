<?php

use Symfony\Component\Yaml\Yaml;

include __DIR__ . '/../vendor/autoload.php';

if(empty($argv[1])){
    echo 'You should tell what file I need to parse';
    die();
}

$yaml = Yaml::parseFile($argv[1]);

$dir = $yaml['target'] or die('No target directory has been given');
$namespace = $yaml['namespace'] or die('No namespace has been given');

$structures = $yaml['structures'] or die('No structures have been given');
/**
 * @var string $className
 * @var array $struct
 */
$namespace = new \Nette\PhpGenerator\PhpNamespace($namespace);
foreach ($structures as $className => $struct){
    $class = new Nette\PhpGenerator\ClassType(phpCaseFunction($className), $namespace);

    $class
        ->addComment('Automatic generated datastructure');

    $importFunction = $class->addMethod('import');
    $param = $importFunction->addParameter('arrayData');
    $param->setTypeHint('array');
    $importFunction->setVisibility('public');

    foreach ($struct['fields'] as $field) {
        $name = $field['name'] or die('Missing field name');
        $key = !empty($field['key']) ? $field['key'] : $name;
        $type = $field['type'] or die('Missing type');
        $optional = false;
        if(strpos($type, '?') === 0){
            $type = substr($type, 1);
            $optional = true;
        }
        $primitiveTypes = ['string', 'bool', 'int', 'float'];
        $baseType = '';
        if (in_array($type, $primitiveTypes, true)){
            $baseType = 'primitive';
        } elseif ($type === 'array'){
            $baseType = 'array';
        } elseif ($type === 'map'){
            $baseType = 'map';
        } else {
            throw new \ParseError("Unknown type $type");
        }


        $variableName = 'property' . phpCaseFunction($key, false);
        $prop = $class->addProperty($variableName);
        $prop->addComment("@var $type");
        $prop->setVisibility('private');


        $method = $class->addMethod('get' . phpCaseFunction($name));
        $method->setVisibility('public');
        $method->addBody('return $this->'.$variableName.';');

        $importFunction->addBody('if ($arrayData[?] !== null) {', [$key]);
        if($baseType === 'primitive') {

            $importFunction->addBody('    $this->? = $arrayData[?];', [$variableName, $key]);
        } elseif($baseType === 'array') {

            $importFunction->addBody('    foreach ($arrayData[?] as $line) {', [$key]);
            $importFunction->addBody('        $this->?[] = $line;', [$variableName]);
            $importFunction->addBody('    }', []);
        } elseif($baseType === 'map') {
            $importFunction->addBody('    foreach ($arrayData[?] as $key => $line) {', [$key]);
            $importFunction->addBody('        $this->?[$key] = $line;', [$variableName]);
            $importFunction->addBody('    }', []);
        }

        if(!$optional) {
            $importFunction->addBody('} else {');
            $importFunction->addBody('    throw new \RuntimeException("Missing the key ?");', [$key]);

        }
        $importFunction->addBody('}');


    }

    $printer = new Nette\PhpGenerator\PsrPrinter;
    if(!is_dir($dir)) {
        if (!mkdir($dir, 0777, true) && !is_dir($dir)) {
            throw new \RuntimeException(
                sprintf('Directory "%s" was not created', $dir)
            );
        }
    }
    $printClass = '<?php'. PHP_EOL .$printer->printClass($class);
    file_put_contents($dir.'/'.phpCaseFunction($className). '.php', $printClass);

}


function phpCaseFunction(string $input, bool $firstUpper = true){
    $out = [];
    $nextUpper = $firstUpper;
    for($i =0, $iMax = strlen($input); $i < $iMax; $i++) {
        if($input[$i] === '_' || $input[$i] === '-'  || trim($input[$i]) === ''){
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
    return implode('',$out);



}


