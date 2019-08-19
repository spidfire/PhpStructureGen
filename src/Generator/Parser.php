<?php


namespace PhpStructureGenerator\Generator;


use Nette\PhpGenerator\PhpNamespace;

class Parser
{

    function parse (array $structure, Settings $settings) {

        $dir = $structure['target'] or die('No target directory has been given');
        $namespace = new PhpNamespace($structure['namespace']) or die('No namespace has been given');
        $settings->setNamespace($namespace);

        $structures = $structure['structures'] or die('No structures have been given');
        /**
         * @var string $className
         * @var array $struct
         */
        foreach ($structures as $className => $struct){

            $structureName = new NameHolder($className);
            $classGenerator = new ClassGenerator(
                $structureName,
                $settings
            );

            foreach ($struct['fields'] as $field) {
                $field = FieldFactory::createFromObject($field);
                $classGenerator->addField($field);
            }

            if(!is_dir($dir)) {
                if (!mkdir($dir, 0777, true) && !is_dir($dir)) {
                    throw new \RuntimeException(
                        sprintf('Directory "%s" was not created', $dir)
                    );
                }
            }
            $printClass = $classGenerator->export();
            $filename = $dir . '/' . $structureName->PascalCase() . '.php';
            echo "Generated $filename\n";
            file_put_contents($filename, $printClass);

        }



    }


}