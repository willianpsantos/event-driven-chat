<?php

namespace App\Events;

class CallShowHideVideoEventData
{
    /** @var string */
    public $call;

    /** @var string */
    public $member;

    /** @var boolean */
    public $host = false;

    /** @var boolean */
    public $show = false;
}