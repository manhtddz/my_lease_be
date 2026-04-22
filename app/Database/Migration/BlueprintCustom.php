<?php

namespace App\Database\Migration;

use Closure;
use Core\Providers\Facades\Schema\CustomBlueprint as CoreBlueprintCustom;
use Illuminate\Database\Connection;

class BlueprintCustom extends CoreBlueprintCustom
{
    public function __construct(Connection $connection, $table, Closure $callback = null, $prefix = '')
    {
        parent::__construct($connection, $table, $callback);
    }

    public function defaultFields()
    {
        // soft deletes
        $this->softDeletes();

        // ins date / upd date
        $this->timestamps();
    }

    /**
     * @param int $precision
     */
    public function timestamps($precision = 0)
    {
        $deletedAt = getDeletedAtColumn();
        $deletedBy = getDeletedByColumn();
        $createdAt = getCreatedAtColumn();
        $createdBy = getCreatedByColumn();
        $updatedAt = getUpdatedAtColumn();
        $updatedBy = getUpdatedByColumn();

        if (!empty($createdAt)) $this->timestamp($createdAt)->useCurrent()->comment(getConfig('model_field_name.created_at'));
        if (!empty($createdBy)) $this->integer($createdBy)->unsigned()->comment(getConfig('model_field_name.created_by'));
        if (!empty($updatedAt)) $this->timestamp($updatedAt)->nullable()->comment(getConfig('model_field_name.updated_at'));
        if (!empty($updatedBy)) $this->integer($updatedBy)->unsigned()->nullable()->comment(getConfig('model_field_name.updated_by'));
        if (!empty($deletedAt)) $this->timestamp($deletedAt)->nullable()->comment(getConfig('model_field_name.deleted_at'));
        if (!empty($deletedBy)) $this->integer($deletedBy)->unsigned()->nullable()->comment(getConfig('model_field_name.deleted_by'));
    }


}
