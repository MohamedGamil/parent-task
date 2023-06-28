<?php

namespace App\Repositories\Types;

/**
 * Data Source Defined Types
 */
enum DataSourceType: string
{
    case Json = 'json';
    case Eloquent = 'eloquent';
}
