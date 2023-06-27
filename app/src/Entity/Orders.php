<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrdersRepository::class)]
class Orders
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'no')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Customers $customer = null;

    #[ORM\Column(length: 255)]
    private ?string $totalAmount = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $orderDate = null;

    #[ORM\OneToMany(mappedBy: 'orderId', targetEntity: OrderItem::class)]
    private Collection $no;

    public function __construct()
    {
        $this->no = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomer(): ?Customers
    {
        return $this->customer;
    }

    public function setCustomer(?Customers $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    public function getTotalAmount(): ?string
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(string $totalAmount): static
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    public function getOrderDate(): ?\DateTimeInterface
    {
        return $this->orderDate;
    }

    public function setOrderDate(?\DateTimeInterface $orderDate): static
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    /**
     * @return Collection<int, OrderItem>
     */
    public function getNo(): Collection
    {
        return $this->no;
    }

    public function addNo(OrderItem $no): static
    {
        if (!$this->no->contains($no)) {
            $this->no->add($no);
            $no->setOrderId($this);
        }

        return $this;
    }

    public function removeNo(OrderItem $no): static
    {
        if ($this->no->removeElement($no)) {
            // set the owning side to null (unless already changed)
            if ($no->getOrderId() === $this) {
                $no->setOrderId(null);
            }
        }

        return $this;
    }
}
