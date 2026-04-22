<?php

namespace Core\Database\Eloquent;

use Illuminate\Database\Concerns\BuildsQueries;
use Illuminate\Database\Eloquent\Concerns\QueriesRelationships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Traits\ForwardsCalls;

class BaseEloquentBuilder extends Builder
{
    use BuildsQueries, ForwardsCalls, QueriesRelationships {
        BuildsQueries::sole as baseSole;
    }

    const CONS_INSERT = 0;
    const CONS_UPDATE = 1;

    public function __construct(QueryBuilder $query)
    {
        parent::__construct($query);
    }

    protected function _prepareValues($values, $type = self::CONS_INSERT)
    {
        $datetime = date('Y-m-d H:i:s');
        $modelField = getConfig('model_field');

        if (self::CONS_INSERT == $type) {
            // created_at
            if (!empty($modelField['created']['at']) && !array_key_exists($modelField['created']['at'], $values)) {
                $values[$modelField['created']['at']] = $datetime;
            }

            // created_by
            if (!empty($modelField['created']['by']) && !array_key_exists($modelField['created']['by'], $values)) {
                $values[$modelField['created']['by']] = getLoginUser($this->getModel()->getKeyName());
            }

            return $values;
        }

        // updated_at
        if (!empty($modelField['updated']['at']) && !array_key_exists($modelField['updated']['at'], $values)) {
            $values[$modelField['updated']['at']] = $datetime;
        }

        // updated_by
        if (!empty($modelField['updated']['by']) && !array_key_exists($modelField['updated']['by'], $values)) {
            $values[$modelField['updated']['by']] = getLoginUser($this->getModel()->getKeyName());
        }

        return $values;
    }

    /**
     * Save a new model and return the instance.
     *
     * @param array $attributes
     * @return BaseEloquentBuilder|Model
     */
    public function create(array $attributes = [])
    {
        return parent::create($this->_prepareValues($attributes));
    }

    /**
     * Insert new records into the database.
     *
     * @param array $values
     * @return bool
     */
    public function insert(array $values)
    {
        // array of arrays (multi-row)
        if (isset($values[0]) && is_array($values[0])) {
            $prepared = [];
            foreach ($values as $row) {
                $prepared[] = $this->_prepareValues($row, self::CONS_INSERT);
            }
            return parent::insert($prepared);
        }

        return parent::insert($this->_prepareValues($values));
    }

    /**
     * Insert a new record and get the value of the primary key.
     *
     * @param array $values
     * @param null $sequence
     * @return int
     */
    public function insertGetId(array $values, $sequence = null)
    {
        return parent::insertGetId($this->_prepareValues($values), $sequence);
    }

    /**
     * Update records in the database.
     *
     * @param array $values
     * @return int
     */
    public function update(array $values)
    {
        return parent::update($this->_prepareValues($values, self::CONS_UPDATE));
    }
}
