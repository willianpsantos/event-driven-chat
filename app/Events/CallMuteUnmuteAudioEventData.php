<?php

namespace App\Events;

class CallMuteUnmuteAudioEventData
{
    /** @var string */
    public $call;

    /** @var string */
    public $member;

    /** @var boolean */
    public $host = false;

    /** @var boolean */
    public $mute = false;
}
