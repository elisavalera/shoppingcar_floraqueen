<?php

namespace App\Service;

class CartService
{
    private $items = [];

    public function addItem(string $item): bool
    {
        // Add the item to the cart
        $this->items[] = $item;

        return true;
    }

    public function calculateTotalAmount(): float
    {
        $totalAmount = 0;

        // Loop through the items in the cart and calculate the total amount
        foreach ($this->items as $item) {
            // Determine the item type (product or voucher) and calculate the price accordingly
            if ($this->isProduct($item)) {
                $totalAmount += $this->calculateProductPrice($item);
            } elseif ($this->isVoucher($item)) {
                $totalAmount += $this->calculateVoucherPrice($item);
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
}
