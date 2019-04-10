<?php

namespace Mujiciok\ResourceSelectors\Generators;

class CollectionResourceWithSelectorsGenerator extends FileGenerator
{
    protected $directory = 'Http/Resources';

    protected $stub = 'resource-collection-with-selectors';

    protected $messages = [
        self::SUCCESS      => 'Resource collection created successfully.',
        self::FILE_EXISTS  => 'Resource collection with selectors already exists!',
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
    public function getFormattedFilename(string $filename) : string
    {
        $filename = ends_with($filename, "Resource") ? str_replace("Resource", "", $filename) : $filename;
        $filename = ends_with($filename, "Collection") ? $filename : ($filename . "Collection");

        return $filename;
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