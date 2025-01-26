<?php

namespace App\EventListener\Product;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Enqueue\Client\ProducerInterface;

#[AsEntityListener(event: Events::postPersist, method: 'postPersist', entity: Product::class)]
readonly class CreateProductEventListener
{
    const PRODUCT_CREATED_EVENT = 'product_created';
    const INVENTORY_SERVICE = 'inventory-service';
    const SHOPPING_SERVICE = 'shopping-service';
    const RECEIVER_TOPICS = [
        self::INVENTORY_SERVICE,
        self::SHOPPING_SERVICE
    ];

    public function __construct(private ProducerInterface $producer)
    {
    }

    public function PostPersist(Product $product): void
    {
        $productDataEvent = ['data' => ['id' => $product->getId(), 'enabled' => $product->isEnabled()]];

        foreach (self::RECEIVER_TOPICS as $topic) {
            $this->producer->sendEvent("$topic-" . self::PRODUCT_CREATED_EVENT, $productDataEvent);
        }
    }
}
