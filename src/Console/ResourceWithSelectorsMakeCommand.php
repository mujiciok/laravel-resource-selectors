<?php

namespace Mujiciok\ResourceSelectors\Console;

use Mujiciok\ResourceSelectors\Generators\CollectionResourceWithSelectorsGenerator;
use Mujiciok\ResourceSelectors\Generators\ResourceWithSelectorsGenerator;
use Mujiciok\ResourceSelectors\Generators\FileGeneratorInterface;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\ResourceMakeCommand;
use Symfony\Component\Console\Input\InputOption;

class ResourceWithSelectorsMakeCommand extends ResourceMakeCommand
{
    protected $signature = 'make:resource-selectors {name}';
    
    protected $description = 'Create a new resource with selectors';
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct($files);
        
        $this->addOption('collection', 'c', InputOption::VALUE_NONE, 'Create a new resource collection with selectors');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() : void
    {
        $filename = $this->arguments()['name'];

        $isCollection = $this->options()['collection'] || ends_with($filename, "Collection");

        /** @var FileGeneratorInterface $generator */
        $generator = $isCollection
            ? new CollectionResourceWithSelectorsGenerator($filename)
            : new ResourceWithSelectorsGenerator($filename);

        $result = $generator->build();
        
        $this->{$result['type']}($result['message']);
    }
}
