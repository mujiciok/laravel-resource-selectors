<?php

namespace Mujiciok\ResourceSelectors\Generators;

interface FileGeneratorInterface
{
    const SUCCESS         = 'success';
    const FILE_EXISTS     = 'file_exists';
    const MISSING_NAME    = 'missing_name';
    
    /**
     * @return string
     */
    function getFilename() : string;

    /**
     * @return string
     */
    function getDirectory() : string;

    /**
     * @return string
     */
    function getStub() : string;

    /**
     * @return string
     */
    function getMessage(string $type) : string;

    /**
     * @return array
     */
    function getVariables() : array;

    /**
     * @return mixed
     */
    function build();
}