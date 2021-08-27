<?php

namespace App\Messages;

use http\Message;

class SmsMessage
{
    protected array $lines;
    protected string $to;


    public function __construct() {

    }

    public function toNumber($to): self {
        $this->to = $to;
        return $this;
    }

    public function getToNumber() {
        return $this->to;
    }

    public function line($line) {
        $this->lines[] = $line;
        return $this;
    }

    public function getMessage() {
        return collect($this->lines)->implode("\n");
    }
}
