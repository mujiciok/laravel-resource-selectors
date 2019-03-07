<?php

namespace Mujiciok\ResourceSelectors\Generators;

use Illuminate\Support\Facades\File;

abstract class FileGenerator implements FileGeneratorInterface
{
    protected $filename;

    protected $directory;

    protected $stub;

    protected $variables;

    public function __construct($filename, $directory, $stub, $variables = [])
    {
        $this->filename  = $filename;
        $this->directory = $directory;
        $this->stub      = $this->getStubContent($stub);
        $this->variables = $variables;
    }

    /**
     * @param $stubName
     * @return bool|string
     */
    protected function getStubContent($stubName)
    {
        return file_get_contents(__DIR__.'/../Stubs/' . $stubName . '.stub');
    }

    protected function createDirectory()
    {
        $fullDirectoryName = app_path($this->directory);
        
        if (!File::isDirectory($fullDirectoryName)) {
            File::makeDirectory($fullDirectoryName);
        }
    }

    /**
     * @return array
     */
    public function buildInfoMessage() : array
    {
        return [
            'type'    => 'info', 
            'message' => $this->getMessage(self::SUCCESS),
        ];
    }

    /**
     * @param $errorType
     * @return array
     */
    public function buildErrorMessage($errorType) : array
    {
        return [
            'type'    => 'error',
            'message' => $this->getMessage($errorType),
        ];
    }
    
    /**
     * @return mixed
     */
    public function build()
    {
        $this->createDirectory();
        
        $fullFilename = app_path("{$this->directory}/{$this->filename}.php");
        if (file_exists($fullFilename)) {
            return $this->buildErrorMessage(self::FILE_EXISTS);
        }
        
        foreach ($this->variables as $variableName => $variableValue) {
            $this->stub = str_replace(
                "{{" . $variableName . "}}",
                $variableValue,
                $this->stub
            );
        }

        file_put_contents(app_path("{$this->directory}/{$this->filename}.php"), $this->stub);

        return $this->buildInfoMessage();
    }
}