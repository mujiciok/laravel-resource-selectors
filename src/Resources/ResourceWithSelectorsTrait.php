<?php

namespace Mujiciok\ResourceSelectors\Resources;

trait ResourceWithSelectorsTrait
{
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

    /**
     * @param array $filters
     * @param string $filter
     */
    protected function addFilters(array $filters, string $filter)
    {
        switch ($filter) {
            case ResourceWithSelectorsInterface::FILTER_ONLY:
                $this->only($filters[$filter]);
                break;
            case ResourceWithSelectorsInterface::FILTER_EXCEPT:
                $this->except($filters[$filter]);
                break;
            default:
                break;
        }
    }
}