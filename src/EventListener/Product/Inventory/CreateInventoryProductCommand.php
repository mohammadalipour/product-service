<?php

namespace App\EventListener\Product\Inventory;

class CreateInventoryProductCommand
{
    public function __construct(private readonly string $content)
    {
    }

    public function getContent(): string
    {
        return $this->content;
    }
}