<?php

namespace App\Models\Concerns;

use App\Models\Owner;
use App\Models\Property;
use App\Models\PropertyRoom;
use App\Models\Supplier;
use App\Models\Tenant;

trait HasViewId
{
    protected function _afterSave()
    {
        if (!in_array($this->getTable(), [Tenant::getTableName(), Owner::getTableName()])) {
            $this->autoSaveViewId();
        }
        parent::_afterSave();
    }

    public function autoSaveViewId(): void
    {
        if (!$this->view_id && $this->id) {
            $this->view_id = $this->makeViewIdValue();
            $this->save();
        }
    }

    // override
    public function getDirtyForUpdate()
    {
        $dirty = $this->getDirty();

        // custom for case auto update view_id by id when insert
        if (!empty($dirty) && array_key_first($dirty) == 'view_id'){ // not update time
            $dirty[$this->getUpdatedByColumn()] = null;
        }

        return $dirty;
    }

    public function makeViewIdValue()
    {
        switch ($this->getTable()) {
            case Owner::getTableName():
                $prefix = 'L';
                break;
            case Supplier::getTableName():
                $prefix = 'S';
                break;
            case Property::getTableName():
                $prefix = 'P';
                break;
            case PropertyRoom::getTableName():
                $prefix = 'R';
                break;
            //case other

            default:
                $prefix = '';
                break;
        }
        return genViewId($prefix, $this->id);
    }

}
