<?php

namespace Mujiciok\ResourceSelectors\Resources;

interface ResourceWithSelectorsInterface
{
    const FILTER_ONLY   = 'only';
    const FILTER_EXCEPT = 'except';

    const FILTERS = [
        self::FILTER_ONLY,
        self::FILTER_EXCEPT,
    ];

    /**
     * @param array $filters
     */
    public function filters(array $filters = []);

    /**
     * @param array $only
     */
    public function only(array $only = []);

    /**
     * @param array $except
     */
    public function except(array $except = []);
}