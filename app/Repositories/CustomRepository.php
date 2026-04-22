<?php

namespace App\Repositories;

use Core\Repositories\BaseRepository;

class CustomRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getListForIndex($params, $fields = ['*'])
    {
        $sortField = !empty($params['sort']) ? $params['sort'] : 'id';
        $sortType = !empty($params['direction']) ? $params['direction'] : 'desc';

        $builder = $this->_buildSelectForIndex($fields);
        $this->_buildConditionForIndex($builder, $params);
        return $builder->orderBy($sortField, $sortType)->paginate(getConfig('page_number'));
    }

    public function getListForExport($params, $fields = ['*'])
    {
        $sortField = !empty($params['sort']) ? $params['sort'] : 'id';
        $sortType = !empty($params['direction']) ? $params['direction'] : 'desc';

        $builder = $this->_buildSelectForExport($fields);
        $this->_buildConditionForExport($builder, $params);
        return $builder->orderBy($sortField, $sortType)->get();
    }

    protected function _buildSelectForIndex($fields)
    {
        return $this->select($fields);
    }

    protected function _buildSelectForExport($fields)
    {
        return $this->select($fields);
    }

    protected function _buildConditionForIndex(&$builder, $params = [])
    {
        //
    }

    protected function _buildConditionForExport(&$builder, $params = [])
    {
        //
    }

    public function modelTableName(): string
    {
        return $this->getModel()->getTable();
    }

    public function modelField(string $column): string
    {
        return $this->getModel()->getQualifiedColumn($column);
    }

    public function modelFields(array $columns): array
    {
        $model = $this->getModel();
        foreach ($columns as $key => $column) {
            $columns[$key] = $model->getQualifiedColumn(column: $column);
        }
        return $columns;
    }

}
