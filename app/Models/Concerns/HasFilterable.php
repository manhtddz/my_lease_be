<?php


namespace App\Models\Concerns;


use App\Models\Scopes\FilterableScope;

trait HasFilterable
{
    use FilterableScope;

}