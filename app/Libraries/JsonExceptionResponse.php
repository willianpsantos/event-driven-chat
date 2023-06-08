<?php

namespace App\Libraries;

use Exception;

class JsonExceptionResponse
{
    public $type;

    public $message;

    public $trace;

    public static function parse(Exception $ex) {
        $obj = new JsonExceptionResponse();

        $obj->type = get_class($ex);
        $obj->message = $ex->getMessage();
        $obj->trace = [];
        $trace = $ex->getTrace();

        foreach($trace as $t) {
            $line = 'Function ' . @$t['function'] . ' - Line '. @$t['line'] . ' - File ' . @$t['file'];
            $obj->trace[] = $line;
        }

        return $obj;
    }
}
