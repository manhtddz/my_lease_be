<?php

namespace App\Database\Migration;

use Illuminate\Database\Schema\Builder;

/**
 * @method static Builder create(string $table, \Closure $callback)
 * @method static Builder drop(string $table)
 * @method static Builder dropIfExists(string $table)
 * @method static Builder table(string $table, \Closure $callback)
 *
 * @see \Illuminate\Database\Schema\Builder
 */
class SchemaCustom extends \Illuminate\Support\Facades\Schema
{
    /**
     * Get a schema builder instance for a connection.
     *
     * @param  string $name
     * @return Builder
     */
    public static function connection($name): Builder
    {
        $schema = static::$app['db']->connection($name)->getSchemaBuilder();
        return self::_changeBlueprint($schema);
    }

    /**
     * Get a schema builder instance for the default connection.
     *
     * @return string|Builder
     */
    protected static function getFacadeAccessor(): string|Builder
    {
        return 'db.custom.schema';
    }

    protected static function _changeBlueprint($schema)
    {
        $schema->blueprintResolver(function ($table, $callback) {
            return new BlueprintCustom($table, $callback);
        });
        return $schema;
    }
}
