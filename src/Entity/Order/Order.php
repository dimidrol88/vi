<?php

namespace App\Entity\Order;

use App\Entity\User;
use App\Repository\Order\OrderRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`orders`")
 */
class Order
{
    const STATUS_NEW = 'new';
    const STATUS_PAID = 'paid';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="integer", name="user_id")
     */
    private $userId;
    /**
     * @ORM\Column(type="string", length=10)
     */
    private $status;
    /**
     * @var float
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $price;
    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private $created;
    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private $updated;
    /**
     * @var Item[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="Item", mappedBy="order", orphanRemoval=true, cascade={"persist"})
     */
    private $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->created = new DateTimeImmutable();
        $this->setUpdatedAt(new DateTimeImmutable());
        $this->setStatus(self::STATUS_NEW);
        $this->setUserId(User::DEFAULT_USER_ID);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(): void
    {
        $price = 0.00;

        foreach ($this->items as $item){
            $product = $item->getProduct();

            $price += $product->getPrice();
        }

        $this->price = $price;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->created;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->created;
    }

    public function setUpdatedAt(DateTimeImmutable $updated): void
    {
        $this->updated = $updated;
    }

    private function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

}
