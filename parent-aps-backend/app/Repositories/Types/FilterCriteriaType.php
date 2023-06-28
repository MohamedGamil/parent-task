<?php

namespace App\Repositories\Types;

/**
 * Filter Criteria Defined Types
 */
enum FilterCriteriaType: string
{
    case JSON = 'json';
    case ELOQUENT = 'eloquent';
}
