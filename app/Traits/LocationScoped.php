<?php

namespace App\Traits;

use App\Scopes\LocationScope;

trait LocationScoped
{
    /**
     * Boot the location scope for the trait.
     *
     * @return void
     */
    protected static function bootLocationScoped()
    {
        static::addGlobalScope(new LocationScope());
    }
}
