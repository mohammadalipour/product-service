<?php

namespace App\Message;
use Symfony\Component\Messenger\Attribute\AsMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class UpdateProductMessage
{
    private string $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}