<?php
namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $electronics = new Category();
        $electronics->setName('Electronics');
        $electronics->setEnabled(true);

        $laptops = new Category();
        $laptops->setName('Laptops');
        $laptops->setParent($electronics);
        $laptops->setEnabled(true);

        $mobiles = new Category();
        $mobiles->setName('Mobiles');
        $mobiles->setParent($electronics);
        $mobiles->setEnabled(false); // Example of a disabled category

        $manager->persist($electronics);
        $manager->persist($laptops);
        $manager->persist($mobiles);
        $manager->flush();
    }
}
