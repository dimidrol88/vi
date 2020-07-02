<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 20; $i++) {
            $product = new Product();
            $product->setName('new product ' . $i);
            $product->setPrice(rand(0, 1000) + $i);

            $manager->persist($product);
        }

        $manager->flush();
    }
}
