<?php

namespace App\Messages;

use http\Message;
use Illuminate\Support\Arr;

class SmsMessage
{
    protected array $lines;
    protected ?string $to = null;


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
        Arr::prepend($this->lines, "[" . config("join_sms.header") . "]");
        return collect($this->lines)->implode("\n");
    }
}
