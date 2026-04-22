<?php

namespace Core\Database\Eloquent\Model;

use Core\Database\Eloquent\BaseEloquentBuilder;
use Core\Database\Eloquent\BaseQueryBuilder;
use Core\Database\Eloquent\Relations\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class BaseModel extends Model
{
    use HasFactory;

    // Custom Relation with deleted_flag, deleted_at
    use HasRelationships;

    public $timestamps = false;

    protected array $dates = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->mergeActionBy();
    }

    protected function mergeActionBy()
    {
        if (empty($this->fillable)) {
            return;
        }

        $merge = [];

        if (!empty($this->getDeletedFlag())) $merge[] = $this->getDeletedFlag();
        if (!empty($this->getCreatedByColumn())) $merge[] = $this->getCreatedByColumn();
        if (!empty($this->getCreatedAtColumn())) $merge[] = $this->getCreatedAtColumn();
        if (!empty($this->getUpdatedByColumn())) $merge[] = $this->getUpdatedByColumn();
        if (!empty($this->getUpdatedAtColumn())) $merge[] = $this->getUpdatedAtColumn();
        if (!empty($this->getDeletedByColumn())) $merge[] = $this->getDeletedByColumn();
        if (!empty($this->getDeletedAtColumn())) $merge[] = $this->getDeletedAtColumn();

        $this->mergeFillable($merge);
    }

    /**
     * Create a new Eloquent query builder for the model.
     */
    public function newEloquentBuilder($query)
    {
        return new BaseEloquentBuilder($query);
    }

    /**
     * Get a new query builder instance for the connection.
     */
    public function newBaseQueryBuilder()
    {
        $connection = $this->getConnection();

        return new BaseQueryBuilder($connection, $connection->getQueryGrammar(), $connection->getPostProcessor());
    }

    /**
     * get deleted flag column
     *
     * @return string|null
     */
    public function getDeletedFlag(): string|null
    {
        return getConfig('model_field.deleted.flag');
    }

    /**
     * get deleted at column
     *
     * @return string|null
     */
    public function getDeletedAtColumn(): string|null
    {
        return getConfig('model_field.deleted.at');
    }

    /**
     * get deleted by column
     *
     * @return string|null
     */
    public function getDeletedByColumn(): string|null
    {
        return getConfig('model_field.deleted.by');
    }

    /**
     * get created at column
     *
     * @return string|null
     */
    public function getCreatedAtColumn(): string|null
    {
        return getConfig('model_field.created.at');
    }

    /**
     * get created by column
     *
     * @return string|null
     */
    public function getCreatedByColumn(): string|null
    {
        return getConfig('model_field.created.by');
    }

    /**
     * get updated at column
     *
     * @return string|null
     */
    public function getUpdatedAtColumn(): string|null
    {
        return getConfig('model_field.updated.at');
    }

    /**
     * get updated by column
     *
     * @return string|null
     */
    public function getUpdatedByColumn(): string|null
    {
        return getConfig('model_field.updated.by');
    }

    /**
     * get qualified column
     *
     * @param $column
     * @return string|null
     */
    public function getQualifiedColumn($column): string|null
    {
        return $this->table . '.' . $column;
    }

    /**
     * @param array $options
     * @return bool
     */
    public function save(array $options = [])
    {
        $this->_beforeSave();
        $saved = parent::save($options);
        $this->_afterSave();

        return $saved;
    }

    protected function _beforeSave(){
        //
        $now = date('Y-m-d H:i:s');

        $attribute = $this->getAttributes();
        $getKeyName = $this->getKeyName();
        $createdAt = $this->getCreatedAtColumn();
        $updatedAt = $this->getUpdatedAtColumn();
        $createdBy = $this->getCreatedByColumn();
        $updatedBy = $this->getUpdatedByColumn();

        // created
        if ($createdAt && empty(Arr::get($attribute, $getKeyName))) {
            $attribute[$createdAt] = $now;
            $attribute[$updatedAt] = $now;
        }
        if ($createdBy && empty(Arr::get($attribute, $getKeyName))) {
            if (isApiArea()) {
                $attribute[$createdBy] = 0;
            }
            $attribute[$createdBy] = $attribute[$createdBy] ?? getLoginUser($this->getKeyName());
        };
        // updated
        if ($updatedAt && !empty(Arr::get($attribute, $getKeyName))) $attribute[$updatedAt] = array_key_exists($updatedAt, $attribute) ? $attribute[$updatedAt] : $now;
        if ($updatedBy && !empty(Arr::get($attribute, $getKeyName))) $attribute[$updatedBy] = array_key_exists($updatedBy, $attribute) ? $attribute[$updatedBy] : getLoginUser($this->getKeyName());

        $this->setRawAttributes([])->fill($attribute);
    }

    protected function _afterSave(){
        //
    }


}
