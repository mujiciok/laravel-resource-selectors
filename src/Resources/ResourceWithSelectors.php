<?php

namespace Mujiciok\ResourceSelectors\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ResourceWithSelectors extends Resource
{
    /**
     * List of attributes to be shown
     *
     * @var mixed
     */
    protected $showOnly;

    /**
     * List of attributes to be hidden
     *
     * @var mixed
     */
    protected $showExcept;


    public function __construct($resource)
    {
        $request = request()->request;

        $this->showOnly   = $request->get(ResourceCollectionWithSelectors::FILTER_ONLY);
        $this->showExcept = $request->get(ResourceCollectionWithSelectors::FILTER_EXCEPT);

        parent::__construct($resource);
    }

    /**
     * @param array $data
     * @return array
     */
    public function getResource(array $data) : array
    {
        if (!empty($this->showOnly)) {
            $data = array_intersect_key($data, array_flip($this->showOnly));
        }

        if (!empty($this->showExcept)) {
            $data = array_diff_key($data, array_flip($this->showExcept));
        }

        return $data;
    }
}