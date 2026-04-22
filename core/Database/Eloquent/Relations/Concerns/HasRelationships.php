<?php

namespace Core\Database\Eloquent\Relations\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Core\Database\Eloquent\Relations\BaseBelongsToMany;

trait HasRelationships
{
    /**
     * Instantiate a new BelongsToMany relationship.
     *
     * @param Builder $query
     * @param Model $parent
     * @param $table
     * @param $foreignPivotKey
     * @param $relatedPivotKey
     * @param $parentKey
     * @param $relatedKey
     * @param null $relationName
     * @return BaseBelongsToMany
     */
    protected function newBelongsToMany(Builder $query, Model $parent, $table, $foreignPivotKey, $relatedPivotKey, $parentKey, $relatedKey, $relationName = null)
    {
        return new BaseBelongsToMany($query, $parent, $table, $foreignPivotKey, $relatedPivotKey, $parentKey, $relatedKey, $relationName);
    }
}
