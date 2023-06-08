<?php

namespace App\Libraries;

class JsonResponse
{
    /** @var bool */
    public $success;

    /** @var string */
    public $message;

    /** @var string */
    public $field;

    /** @var object */
    public $data;

    /** @var JsonExceptionResponse */
    public $exception;

    /** @var string */
    public $redirectTo;

    /** @var int */
    public $redirectDelay;
}
