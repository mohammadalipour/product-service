<?php
namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Fetch Categories
        $electronics = $manager->getRepository(Category::class)->findOneBy(['name' => 'Electronics']);
        $laptops = $manager->getRepository(Category::class)->findOneBy(['name' => 'Laptops']);
        $mobiles = $manager->getRepository(Category::class)->findOneBy(['name' => 'Mobiles']);

        // Create Products with image paths
        $macbook = new Product();
        $macbook->setName('MacBook Pro');
        $macbook->setPrice(1999.99);
        $macbook->setDescription('A powerful laptop for professionals.');
        $macbook->setCategory($laptops);
        $macbook->setImage('images/macbook_pro.jpg'); // Set image path
        $macbook->setEnabled(true);
        $manager->persist($macbook);
        $manager->flush();

        $iphone = new Product();
        $iphone->setName('iPhone 14');
        $iphone->setPrice(999.99);
        $iphone->setDescription('The latest iPhone with advanced features.');
        $iphone->setCategory($mobiles);
        $iphone->setImage('images/iphone_14.jpg'); // Set image path
        $iphone->setEnabled(true);
        $manager->persist($iphone);
        $manager->flush();

        $headphones = new Product();
        $headphones->setName('Sony WH-1000XM5');
        $headphones->setPrice(399.99);
        $headphones->setDescription('High-quality noise-canceling headphones.');
        $headphones->setCategory($electronics);
        $headphones->setImage('images/sony_headphones.jpg'); // Set image path
        $headphones->setEnabled(true);
        $manager->persist($headphones);
        $manager->flush();
    }
}
