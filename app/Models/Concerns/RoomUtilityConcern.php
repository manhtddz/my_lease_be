<?php

namespace App\Models\Concerns;

trait RoomUtilityConcern
{
    public static function getFullColumnNameByType(string $utilityType, string $suffix): string
    {
        return "room_{$utilityType}_bill_{$suffix}";  // eg: room_{electric}_bill_{tenant_id}
    }

    public static function listSupplierIdColumns(string $type): array
    {
        return [
            self::getFullColumnNameByType($type, 'supplier_id1'),
            self::getFullColumnNameByType($type, 'supplier_id2'),
            self::getFullColumnNameByType($type, 'supplier_id3'),
            self::getFullColumnNameByType($type, 'supplier_id4'),
            self::getFullColumnNameByType($type, 'supplier_id5')
        ];
    }

    public static function listSupplierIds(string $utilityType, array $data = []): array
    {
        $ids = [];
        foreach (self::listSupplierIdColumns($utilityType) as $columnName){
            $ids[$columnName] = data_get($data, $columnName);
        }

        return $ids;
    }

    public function getSupplierIds(string $utilityType): array
    {
        return self::listSupplierIds($utilityType, $this->getAttributes());
    }

    public static function listSupplierColumns(string $suffix): array
    {
        return [
            "supplier_id1_{$suffix}",
            "supplier_id2_{$suffix}",
            "supplier_id3_{$suffix}",
            "supplier_id4_{$suffix}",
            "supplier_id5_{$suffix}",
        ];  // eg: supplier_id1_{amount}
    }

}
