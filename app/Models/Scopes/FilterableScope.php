<?php

namespace App\Models\Scopes;

trait FilterableScope
{
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            foreach ($search as $fn) {
                $query->where($fn);
            }
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        })->when($filters['sort'] ?? null, function ($query, $dataSort) {
            foreach ($dataSort as $field => $type){
                if ($field && $type){
                    $query->orderBy($field, $type);
                }
            }
        });
    }

    public function scopeSearch($query, array $filters)
    {

        // default sort id DESC
        if (!$sort = array_filter(data_get($filters, 'sort', []))){
            $query->sortByIdDesc();
        }

        return $query->filter($filters);
    }

}
