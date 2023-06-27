<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;
use App\Entity\Voucher;
use App\Repository\ProductRepository;

class CartService
{
    private $items = [];

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addItem(string $item): bool
    {
        if ($this->isProduct($item)) {
            // Add the item to the cart
            $cartItem = new Product();
            $cartItem->setName($item);
            $cartItem->setDescription($item);
            $cartItem->setPrice($this->calculateProductPrice($item));
        } elseif ($this->isVoucher($item)) {
            $cartItem = new Voucher();
            $cartItem->setCode($item);
            $cartItem->setType($item);
            $cartItem->setValue($this->calculateVoucherPrice($item));
        }
        

        // Persist the entity
        $this->entityManager->persist($cartItem);
        $this->entityManager->flush();

        return true;
    }

    public function calculateTotalAmount(): float
    {
        $totalAmount = 0;
        $cartProducts = $this->entityManager->getRepository(Product::class)->findAll();
        $cartVouchers = $this->entityManager->getRepository(Voucher::class)->findAll();

        foreach ($cartProducts as $product) {
            $name = $product->getName();
            if ($this->isProduct($product->getName())) {
             $totalAmount += $product->getPrice();
            }
        }

        foreach ($cartVouchers as $voucher) {
           
            if ($this->isVoucher($voucher->getCode())) {
                $totalAmount += $voucher->getValue();
               }
        }

        return $totalAmount;
    }

    private function isProduct(string $item): bool
    {
        // Logic to determine if the item is a product
        // Replace this with your own logic based on your product types or identifiers
        return in_array($item, ['ProductA', 'ProductB', 'ProductC']);
    }

    private function isVoucher(string $item): bool
    {
        // Logic to determine if the item is a voucher
        // Replace this with your own logic based on your voucher types or identifiers
        return in_array($item, ['VoucherV', 'VoucherR', 'VoucherS']);
    }

    private function calculateProductPrice(string $product): float
    {
        // Calculate the price for the product
        // Replace this with your own logic to calculate the product price based on the product type
        switch ($product) {
            case 'ProductA':
                return 10;
            case 'ProductB':
                return 8;
            case 'ProductC':
                return 12;
            default:
                return 0;
        }
    }

    private function calculateVoucherPrice(string $voucher): float
    {
        // Calculate the price for the voucher
        // Replace this with your own logic to calculate the voucher price based on the voucher type
        switch ($voucher) {
            case 'VoucherV':
                return 0; // Assuming the voucher does not affect the total amount calculation
            case 'VoucherR':
                return -5; // Deduct 5 from the total amount
            case 'VoucherS':
                return 0; // Assuming the voucher does not affect the total amount calculation
            default:
                return 0;
        }
    }

    public function getCart(): array
    {
        $cartProducts = $this->entityManager->getRepository(Product::class)->findAll();
        $cartVouchers = $this->entityManager->getRepository(Voucher::class)->findAll();
        $cart = [];

        foreach ($cartProducts as $product) {
           
            $cart[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $product->getPrice()
            ];
        }

        foreach ($cartVouchers as $voucher) {
           
            $cart[] = [
                'id' => $voucher->getId(),
                'name' => $voucher->getCode(),
                'price' => $voucher->getValue()
            ];
        }

        return $cart;
    }
}
