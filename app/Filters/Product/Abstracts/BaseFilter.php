<?php

namespace App\Filters\Product\Abstracts;

use Illuminate\Database\Eloquent\Builder;
use App\Filters\Contracts\FilterInterface;

abstract class BaseFilter
{
    protected array $filters = [];
    
    public function apply(Builder $query, array $params): Builder
    {
        foreach ($params as $key => $value) {
            if (isset($this->filters[$key]) && filled($value)) {
                $filter = app($this->filters[$key]);
                $query = $filter->apply($query, $value);
            }
        }

        return $query;
    }
    

}