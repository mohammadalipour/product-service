<?php

namespace App\EventListener\Product;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Enqueue\Client\ProducerInterface;

#[AsEntityListener(event: Events::postRemove, method: 'postRemove', entity: Product::class)]
class RemoveProductEventListener
{
    const PRODUCT_REMOVED_EVENT = 'product_removed';
    const INVENTORY_SERVICE = 'inventory-service';
    const SHOPPING_SERVICE = 'shopping-service';
    const RECEIVER_TOPICS = [
        self::INVENTORY_SERVICE,
        self::SHOPPING_SERVICE
    ];

    public function __construct()
    {
    }

    public function PostRemove(Product $product): void
    {
        $productDataEvent = ['data' => ['id' => $product->getId()]];

        foreach (self::RECEIVER_TOPICS as $topic) {
            $this->producer->sendEvent("$topic-" . self::PRODUCT_REMOVED_EVENT, $productDataEvent);
        }
    }
}
