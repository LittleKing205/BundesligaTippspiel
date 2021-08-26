<?php

namespace App\Messages;

use http\Message;

class PushMessage
{
    protected string $title;
    protected array $lines;
    protected string $icon;
    protected string $link;


    public function __construct() {

    }

    public function title($title): self {
        $this->title = $title;
        return $this;
    }

    public function getTitle() {
        return $this->title;
    }

    public function line($line) {
        $this->lines[] = $line;
        return $this;
    }

    public function getMessage() {
        return collect($this->message)->implode("\n");
    }

    public function icon($icon) {
        $this->icon = $icon;
        return $this;
    }

    public function getIcon() {
        return $this->icon;
    }

    public function link($link) {
        $this->link = $link;
        return $this;
    }

    public function getLink() {
        return $this->link;
    }
}
