<?php

namespace App\Repositories\Types;

/**
 * JSON Data Errors Defined Types
 */
enum JsonDataErrors: string
{
    case JSON_ERROR_STATE_MISMATCH = 'Underflow or the modes mismatch';
    case JSON_ERROR_CTRL_CHAR = 'Unexpected control character found';
    case JSON_ERROR_SYNTAX = 'Syntax error, malformed JSON';
    case JSON_ERROR_DEPTH = 'Maximum depth exceeded';
    case JSON_ERROR_UTF8 = 'Malformed UTF-8 characters, possibly incorrectly encoded';
}
