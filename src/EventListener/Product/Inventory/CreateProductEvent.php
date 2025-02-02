<?php

namespace App\EventListener\Product\Inventory;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Serializer\Encoder\EncoderInterface;

#[AsEntityListener(event: Events::postPersist, method: 'postPersist', entity: Product::class)]
class CreateProductEvent
{
    public function __construct(private readonly MessageBusInterface $bus, private readonly EncoderInterface $serializer)
    {
    }
    /**
     * @throws ExceptionInterface
     */
    public function PostPersist(Product $product): void
    {
        $productDataEvent = ['data' => ['id' => $product->getId(), 'enabled' => $product->isEnabled()]];
        dump(['inventory' => $productDataEvent]);
        $this->bus->dispatch(new CreateInventoryProductCommand($this->serializer->encode($productDataEvent,'json')));
    }
}