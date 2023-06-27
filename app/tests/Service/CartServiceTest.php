<?php

namespace Service;

use App\Service\CartService;
use PHPUnit\Framework\TestCase;

class CartServiceTest extends TestCase
{
    public function testAddItem(): void
    {
        $cartService = new CartService();
        $this->assertTrue($cartService->addItem('ProductA'));
        $this->assertTrue($cartService->addItem('VoucherS'));
    }

    public function testCalculateTotalAmount(): void
    {
        $cartService = new CartService();
        $cartService->addItem('ProductA');
        $cartService->addItem('ProductB');
        $cartService->addItem('VoucherR');

        $totalAmount = $cartService->calculateTotalAmount();
        $this->assertEquals(13, $totalAmount);
    }

    public function testCalculateTotalAmountWithVoucher(): void
    {
        $cartService = new CartService();
        $cartService->addItem('ProductA');
        $cartService->addItem('ProductA');
        $cartService->addItem('ProductB');
        $cartService->addItem('VoucherV');

        $totalAmount = $cartService->calculateTotalAmount();
        $this->assertEquals(26.5, $totalAmount);
    }
}
