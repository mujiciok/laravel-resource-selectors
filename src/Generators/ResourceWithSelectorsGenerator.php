<?php

namespace Mujiciok\ResourceSelectors\Generators;

class ResourceWithSelectorsGenerator extends FileGenerator
{
    protected $directory = 'Http/Resources';

    protected $stub = 'resource-with-selectors';

    protected $messages = [
        self::SUCCESS      => 'Resource created successfully.',
        self::FILE_EXISTS  => 'Resource with selectors already exists!',
    ];

    protected $variables;

    public function __construct($filename)
    {
        $filename = $this->getFormattedFilename($filename);

        $this->variables = [
            'className' => $filename,
        ];

        parent::__construct($filename, $this->directory, $this->stub, $this->variables);
    }

    /**
     * @return string
     */
    public function getFilename() : string
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     * @return string
     */
    protected function getFormattedFilename(string $filename) : string
    {
        return ends_with($filename, "Resource") ? $filename : ($filename . "Resource");
    }

    /**
     * @return string
     */
    public function getDirectory() : string
    {
        return $this->directory;
    }

    /**
     * @return string
     */
    public function getStub() : string
    {
        return $this->stub;
    }

    /**
     * @param string $type
     * @return string
     */
    public function getMessage(string $type) : string
    {
        return $this->messages[$type];
    }

    /**
     * @return array
     */
    public function getVariables() : array
    {
        return $this->variables;
    }
}