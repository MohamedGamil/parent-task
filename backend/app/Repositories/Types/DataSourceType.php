<?php

namespace App\Repositories\Types;

/**
 * Data Source Defined Types
 */
enum DataSourceType: string
{
    case JSON = 'json';
    case ELOQUENT = 'eloquent';
}
