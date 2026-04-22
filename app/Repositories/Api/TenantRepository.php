<?php

namespace App\Repositories\Api;

use App\Models\Tenant;
use App\Repositories\CustomRepository;

class TenantRepository extends CustomRepository
{
    protected $model = Tenant::class;

    public function getListForSearch($dataSearch = [])
    {
        $name = data_get($dataSearch, 'name');
        $phoneNumber = data_get($dataSearch, 'phone_number');
        $idCardNumber = data_get($dataSearch, 'id_card_number');

        $q = $this->select(['*'])
            ->when($name, function ($query) use ($name) {
                $query->whereLike($this->modelField('name'), $name);
            })
            ->when($phoneNumber, function ($query) use ($phoneNumber) {
                $query->whereLike($this->modelField('phone_number'), $phoneNumber);
            })
            ->when($idCardNumber, function ($query) use ($idCardNumber) {
                $query->whereLike($this->modelField('id_card_number'), $idCardNumber);
            });

        return $q->paginate(getConstant('PER_PAGE_DEFAULT'));
    }
}
