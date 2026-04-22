<?php

namespace Core\Database\Eloquent;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Grammars\Grammar;
use Illuminate\Database\Query\Processors\Processor;
use Closure;

class BaseQueryBuilder extends Builder
{
    public function __construct(ConnectionInterface $connection, Grammar $grammar = null, Processor $processor = null)
    {
        parent::__construct($connection, $grammar, $processor);
    }

    /**
     * Add a join clause to the query.
     *
     * @param \Illuminate\Contracts\Database\Query\Expression|string $table
     * @param Closure|string $first
     * @param null $operator
     * @param null $second
     * @param string $type
     * @param false $where
     * @return $this|BaseQueryBuilder
     */
    public function join($table, $first, $operator = null, $second = null, $type = 'inner', $where = false)
    {
        $deletedFlag = getConfig('model_field.deleted.flag');

        $join = $this->newJoinClause($this, $type, $table);

        // If the first "column" of the join is really a Closure instance the developer
        // is trying to build a join with a complex "on" clause containing more than
        // one condition, so we'll add the join and call a Closure with the query.
        if ($first instanceof Closure) {
            $first($join);

            if (!empty($deletedFlag) && is_string($table)){
                $join->where($table . '.' . $deletedFlag, '=', getConfig('deleted_flag.off'));
            }
            $this->joins[] = $join;

            $this->addBinding($join->getBindings(), 'join');
        }

        // If the column is simply a string, we can assume the join simply has a basic
        // "on" clause with a single condition. So we will just build the join with
        // this simple join clauses attached to it. There is not a join callback.
        else {
            $method = $where ? 'where' : 'on';

            $this->joins[] = empty($deletedFlag)
                ? $join->$method($first, $operator, $second)
                : $join->$method($first, $operator, $second)->where($table . '.' . $deletedFlag, '=', getConfig('deleted_flag.off'));

            $this->addBinding($join->getBindings(), 'join');
        }

        return $this;
    }
}
