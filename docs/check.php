<?php

require_once('vendor/autoload.php');
error_reporting(E_ALL);

class Documentor
{
    const CORE_APP_PATH = 'vendor/follower/core/backend/';
    const CORE_DOCS_PATH = 'vendor/follower/core/docs';

    public function run()
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(self::CORE_APP_PATH),
            RecursiveIteratorIterator::SELF_FIRST);

        foreach ($iterator as $fileInfo) {
            if (!$fileInfo->isDir() && $fileInfo) {
                if ($fileInfo->getExtension() == 'php') {
                    $this->processFile($fileInfo);
                }
            }
        }
    }

    private function getClassName($path)
    {
        $nameArr = explode('/', $path);

        $name = '\\Core\\';
        $push = false;

        foreach ($nameArr as $arr) {
            if ($arr == 'backend') {
                $push = true;
            } else if ($push) {
                $push = true;

                if (substr($arr, -3) == 'php') {
                    $name .= substr($arr, 0, -4);
                } else {
                    $name .= $arr . '\\';
                }
            }
        }

        return $name;
    }

    private function processFile($fileInfo)
    {
        $path = $fileInfo->getPathName();
        $name = $this->getClassName($path);

        if (substr($name, 0, 12) == '\\Core\\Object') {
            return false;
        }

        if (class_exists($name) || trait_exists($name) || interface_exists($name)) {
            $this->analyzeClass($name);
        } else {
            echo 'NOT processed: ' . $name . PHP_EOL . PHP_EOL;
        }
    }

    private function analyzeClass($name)
    {
        $reflexionClass = new \ReflectionClass($name);
        $path = getcwd() . '/' . SELF::CORE_DOCS_PATH . str_replace('\\', '/', $name) . '.md';

        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }

        $data = '';
        $data .= "# $reflexionClass->name\n";

        $methods = $reflexionClass->getMethods();
        $constants = $reflexionClass->getConstants();
        $properties = $reflexionClass->getProperties();

        $data .= "## CONSTANTS\n\n";
        foreach ($constants as $constant => $value) {
            $data .= "#### " . $constant . "\n";
        }

        $data .= "## PROPERTIES\n\n";
        foreach ($properties as $property) {
            $data .= "#### " . $property->name . "\n";
        }

        $data .= "## METHODS\n\n";
        foreach ($methods as $method) {
            $data .= "## " . $method->name . "\n";
            $data .= $this->_processComment($method->getDocComment());
        }

        $file = fopen($path, 'w+');
        fwrite($file, $data);
        fclose($file);
    }

    private function _processComment($text)
    {
        $comment = str_replace('*', "\n", trim($text, '/'));
        return $comment;
    }
}

$documentation = new Documentor();
$documentation->run();
