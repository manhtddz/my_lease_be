<?php

namespace App\Repositories\Api;

use App\Models\User;
use App\Repositories\CustomRepository;

class UserRepository extends CustomRepository
{
    protected $model = User::class;

    public function getListForSearch($dataSearch = [])
    {
        $name = data_get($dataSearch, 'name');
        $email = data_get($dataSearch, 'email');
        $role = data_get($dataSearch, 'role');

        $q = $this->select(['*'])
            ->when($name, function ($query) use ($name){
                $query->whereLike($this->modelField('name'), $name);
            })
            ->when($email, function ($query) use ($email){
                $query->whereLike($this->modelField('email'), $email);
            })
            ->when($role, function ($query) use ($role){
                $query->where($this->modelField('role'), $role);
            });

        return $q->paginate(getConstant('PER_PAGE_DEFAULT'));
    }

    public function getById($id)
    {
        return $this->find($id);
    }
}
