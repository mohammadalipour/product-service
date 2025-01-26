<?php

namespace App\EventListener\Product;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Enqueue\Client\ProducerInterface;

#[AsEntityListener(event: Events::postUpdate, method: 'postUpdate', entity: Product::class)]
readonly class UpdateProductEventListener
{
    const PRODUCT_UPDATED_EVENT = 'product_updated';
    const INVENTORY_SERVICE = 'inventory-service';
    const SHOPPING_SERVICE = 'shopping-service';
    const RECEIVER_TOPICS = [
        self::INVENTORY_SERVICE,
        self::SHOPPING_SERVICE
    ];

    public function __construct(private ProducerInterface $producer)
    {
    }

    public function PostUpdate(Product $product): void
    {
        $productDataEvent = ['data' => ['id' => $product->getId(), 'enabled' => $product->isEnabled()]];

        foreach (self::RECEIVER_TOPICS as $topic) {
            $this->producer->sendEvent("$topic-" . self::PRODUCT_UPDATED_EVENT, $productDataEvent);
        }
    }
}
