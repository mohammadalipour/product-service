<?php
namespace App\Service;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;

class CategoryService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getCategoryTree(): array
    {
        $categories = $this->em->getRepository(Category::class)->findBy(['parent' => null]);

        return $this->buildTree($categories);
    }

    private function buildTree(array $categories): array
    {
        $tree = [];
        foreach ($categories as $category) {
            $tree[] = [
                'id' => $category->getId(),
                'name' => $category->getName(),
                'children' => $this->buildTree($category->getChildren()->toArray()),
            ];
        }
        return $tree;
    }
}
