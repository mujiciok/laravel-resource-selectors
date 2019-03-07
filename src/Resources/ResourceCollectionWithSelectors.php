<?php

namespace Mujiciok\ResourceSelectors\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ResourceCollectionWithSelectors extends ResourceCollection
{
    const FILTER_ONLY   = 'only';
    const FILTER_EXCEPT = 'except';

    const FILTERS = [
        self::FILTER_ONLY,
        self::FILTER_EXCEPT,
    ];

    /**
     * @param array $filters
     * @return ResourceCollectionWithSelectors
     */
    public function filters(array $filters = []) : ResourceCollectionWithSelectors
    {
        $formattedFilters = [];

        foreach (self::FILTERS as $filter) {
            if (isset($filters[$filter])) {
                $formattedFilters[$filter] = $this->formatAttributes($filters[$filter]);
            }
        }

        request()->request->add($formattedFilters);

        return $this;
    }

    /**
     * @param array $only
     * @return ResourceCollectionWithSelectors
     */
    public function only($only = []) : ResourceCollectionWithSelectors
    {
        request()->request->add([self::FILTER_ONLY => $this->formatAttributes($only)]);

        return $this;
    }

    /**
     * @param array $except
     * @return ResourceCollectionWithSelectors
     */
    public function except($except = []) : ResourceCollectionWithSelectors
    {
        request()->request->add([self::FILTER_EXCEPT => $this->formatAttributes($except)]);

        return $this;
    }

    /**
     * @param string $string
     * @return array
     */
    protected function getAttributesFromString(string $string) : array
    {
        return $this->sanitize(explode(',', $string));
    }

    /**
     * @param $attributes
     * @return array
     */
    protected function formatAttributes($attributes) : array
    {
        return is_array($attributes)
            ? $this->sanitize($attributes)
            : $this->getAttributesFromString($attributes);
    }

    /**
     * @param array $data
     * @return array
     */
    protected function sanitize(array $data) : array
    {
        $data = array_map(function ($datum) {
            return trim($datum);
        }, $data);

        return array_filter($data);
    }
}