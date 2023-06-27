<?php

namespace App\Entity;

use App\Repository\OrderItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderItemRepository::class)]
class OrderItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'no')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Orders $orderId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderId(): ?Orders
    {
        return $this->orderId;
    }

    public function setOrderId(?Orders $orderId): static
    {
        $this->orderId = $orderId;

        return $this;
    }
}
