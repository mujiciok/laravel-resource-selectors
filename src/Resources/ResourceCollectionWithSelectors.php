<?php

namespace Mujiciok\ResourceSelectors\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ResourceCollectionWithSelectors extends ResourceCollection implements ResourceWithSelectorsInterface
{
    use ResourceWithSelectorsTrait;

    /**
     * @param array $filters
     * @return ResourceCollectionWithSelectors
     */
    public function filters(array $filters = []) : ResourceCollectionWithSelectors
    {
        foreach (self::FILTERS as $filter) {
            if (isset($filters[$filter])) {
                $this->addFilters($filters, $filter);
            }
        }

        return $this;
    }

    /**
     * @param array $only
     * @return ResourceCollectionWithSelectors
     */
    public function only(array $only = []) : ResourceCollectionWithSelectors
    {
        $requestAttribute = class_basename($this) . '_' . ResourceWithSelectorsInterface::FILTER_ONLY;

        request()->request->add([$requestAttribute => $this->formatAttributes($only)]);

        return $this;
    }

    /**
     * @param array $except
     * @return ResourceCollectionWithSelectors
     */
    public function except(array $except = []) : ResourceCollectionWithSelectors
    {
        $requestAttribute = class_basename($this) . '_' . ResourceWithSelectorsInterface::FILTER_EXCEPT;

        request()->request->add([$requestAttribute => $this->formatAttributes($except)]);

        return $this;
    }
}