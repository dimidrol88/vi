<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Product
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @ORM\Table(name="products")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="product_id_sequence", initialValue=1, allocationSize=1)
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Length(min = 2, max = 250, allowEmptyString = false)
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Assert\GreaterThanOrEqual(value=0.00)
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $price;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }
}
