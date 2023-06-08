<?php

namespace App\Enums;

use Exception;

class MessageReceiverType {
    const USER = 'user';
    const GROUP = 'group';

    private $_type;

    public function __construct(string $type)
    {
        if ( $type !== self::USER && $type !== self::GROUP ) {
            throw new \Exception("$type não é aceito na classe MessageReceiverType");
        }

        $this->_type = $type;
    }

    public function getType() {
        return $this->_type;
    }
}
