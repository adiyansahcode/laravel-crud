<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BaseModel extends Model
{
    // Allow for camelCased attribute access
    public function getAttribute($key)
    {
        return parent::getAttribute(Str::snake($key));
    }

    // Allow for camelCased attribute access
    public function setAttribute($key, $value)
    {
        return parent::setAttribute(Str::snake($key), $value);
    }
}
