<?php

namespace Core\Database\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BaseSoftDeletingScope extends SoftDeletingScope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param Builder $builder
     * @param Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        // deleted flag
        if (!empty($model->getDeletedFlag()) && $model->getApplyDeletedFlag()) {
            $builder->where($model->getQualifiedDeletedFlag(), '=', $model->getDeletedFlagValue());
        }
    }

    /**
     * Extend the query builder with the needed functions.
     *
     * @param Builder $builder
     * @return void
     */
    public function extend(Builder $builder)
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }

        $builder->onDelete(function (Builder $builder) {
            $update = [];

            // deleted_flag
            $deletedFlag = $this->getDeletedFlagColumn($builder);
            if (!empty($deletedFlag)) {
                $update[$deletedFlag] = $builder->getModel()->getDeletedFlagValue(true);
            }

            // deleted_at + updated_at
            $deletedAt = $this->getDeletedAtColumn($builder);
            $updatedAt = $this->getUpdatedAtColumn($builder);
            $update[(!empty($deletedAt) ? $deletedAt : $updatedAt)] = $builder->getModel()->freshTimestampString();

            // deleted_by + updated_by
            $deletedBy = $this->getDeletedByColumn($builder);
            $updatedBy = $this->getUpdatedByColumn($builder);
            $update[(!empty($deletedBy) ? $deletedBy : $updatedBy)] = getLoginUser($builder->getModel()->getKeyName());

            // update
            if (!empty($update)) {
                return $builder->update($update);
            }

            return $builder;
        });
    }

    /**
     * Add the restore extension to the builder.
     *
     * @param Builder $builder
     * @return void
     */
    protected function addRestore(Builder $builder)
    {
        $builder->macro('restore', function (Builder $builder) {
            $builder->withTrashed();

            $update = [];

            // deleted_flag
            $deletedFlag = $builder->getModel()->getDeletedFlag();
            if (!empty($deletedFlag)) {
                $update[$deletedFlag] = $builder->getModel()->getDeletedFlagValue();
            }

            // deleted_at + updated_at
            $deletedAt = $builder->getModel()->getDeletedAtColumn();
            $updatedAt = $builder->getModel()->getUpdatedAtColumn();
            if (!empty($deletedAt)) { // deleted_at
                $update[$deletedAt] = null;
            } else if (!empty($updatedAt)) { // updated_at
                $update[$updatedAt] = $builder->getModel()->freshTimestampString();
            }

            // deleted_by + updated_by
            $deletedBy = $builder->getModel()->getDeletedByColumn();
            $updatedBy = $builder->getModel()->getUpdatedByColumn();
            if (!empty($deletedBy)) { // deleted_by
                $update[$deletedBy] = null;
            } else if (!empty($updatedBy)) { // updated_by
                $update[$updatedBy] = getLoginUser($builder->getModel()->getKeyName());
            }

            // update
            if (!empty($update)) {
                return $builder->update($update);
            }

            return $builder;
        });
    }

    /**
     * Add the without-trashed extension to the builder.
     *
     * @param Builder $builder
     * @return void
     */
    protected function addWithoutTrashed(Builder $builder)
    {
        $builder->macro('withoutTrashed', function (Builder $builder) {
            $model = $builder->getModel();
            $builder->withoutGlobalScope($this);

            // deleted flag
            $deletedFlag = $model->getDeletedFlag();
            if (!empty($deletedFlag)) {
                $builder->where($model->getQualifiedDeletedFlag(), '=', $model->getDeletedFlagValue());
            }

            // deleted at
            $deletedAt = $model->getDeletedAtColumn();
            if (!empty($deletedAt)) {
                $builder->whereNull($model->getQualifiedDeletedAtColumn());
            }

            return $builder;
        });
    }

    /**
     * Add the only-trashed extension to the builder.
     *
     * @param Builder $builder
     * @return void
     */
    protected function addOnlyTrashed(Builder $builder)
    {
        $builder->macro('onlyTrashed', function (Builder $builder) {
            $model = $builder->getModel();
            $builder->withoutGlobalScope($this);

            // deleted flag
            $deletedFlag = $model->getDeletedFlag();
            if (!empty($deletedFlag)) {
                $builder->where($model->getQualifiedDeletedFlag(), '=', $model->getDeletedFlagValue(true));
            }

            // deleted at
            $deletedAt = $model->getDeletedAtColumn();
            if (!empty($deletedAt)) {
                $builder->whereNotNull($model->getQualifiedDeletedAtColumn());
            }

            return $builder;
        });
    }

    /**
     * @param Builder $builder
     * @return string|null
     */
    protected function getUpdatedAtColumn(Builder $builder)
    {
        if (count((array)$builder->getQuery()->joins) > 0) {
            return $builder->getModel()->getQualifiedColumn($builder->getModel()->getUpdatedAtColumn());
        }
        return $builder->getModel()->getUpdatedAtColumn();
    }

    /**
     * @param Builder $builder
     * @return mixed
     */
    protected function getUpdatedByColumn(Builder $builder)
    {
        if (count((array)$builder->getQuery()->joins) > 0) {
            return $builder->getModel()->getQualifiedColumn($builder->getModel()->getUpdatedByColumn());
        }
        return $builder->getModel()->getUpdatedByColumn();
    }

    /**
     * @param Builder $builder
     * @return string
     */
    protected function getDeletedAtColumn(Builder $builder)
    {
        if (count((array)$builder->getQuery()->joins) > 0) {
            return $builder->getModel()->getQualifiedColumn($builder->getModel()->getDeletedAtColumn());
        }
        return $builder->getModel()->getDeletedAtColumn();
    }

    /**
     * @param Builder $builder
     * @return mixed
     */
    protected function getDeletedByColumn(Builder $builder)
    {
        if (count((array)$builder->getQuery()->joins) > 0) {
            return $builder->getModel()->getQualifiedColumn($builder->getModel()->getDeletedByColumn());
        }
        return $builder->getModel()->getDeletedByColumn();
    }

    /**
     * @param Builder $builder
     * @return mixed
     */
    protected function getDeletedFlagColumn(Builder $builder)
    {
        if (count((array)$builder->getQuery()->joins) > 0) {
            return $builder->getModel()->getQualifiedColumn($builder->getModel()->getDeletedFlag());
        }
        return $builder->getModel()->getDeletedFlag();
    }
}
