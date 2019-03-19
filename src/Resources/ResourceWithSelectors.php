<?php

namespace Mujiciok\ResourceSelectors\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ResourceWithSelectors extends Resource implements ResourceWithSelectorsInterface
{
    use ResourceWithSelectorsTrait;

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
     * @param array $filters
     * @return ResourceWithSelectors
     */
    public function filters(array $filters = []) : ResourceWithSelectors
    {
        foreach (ResourceCollectionWithSelectors::FILTERS as $filter) {
            if (isset($filters[$filter])) {
                $this->addFilters($filters, $filter);
            }
        }

        return $this;
    }

    /**
     * @param array $only
     * @return ResourceWithSelectors
     */
    public function only(array $only = []) : ResourceWithSelectors
    {
        $this->showOnly = $this->formatAttributes($only);

        return $this;
    }

    /**
     * @param array $except
     * @return ResourceWithSelectors
     */
    public function except(array $except = []) : ResourceWithSelectors
    {
        $this->showExcept = $this->formatAttributes($except);

        return $this;
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