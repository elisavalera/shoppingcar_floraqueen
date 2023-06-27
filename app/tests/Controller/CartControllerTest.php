<?php 

namespace App\Tests\Controller;

use App\Controller\CartController;
use App\Service\CartService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CartControllerTest extends TestCase
{
    public function testAddToCart(): void
    {
        $item = 'Product A'; // Example item data

        $validator = $this->createMock(ValidatorInterface::class);
        $validator->expects($this->once())
            ->method('validate')
            ->with($item, new NotBlank())
            ->willReturn([]);

        $cartService = $this->createMock(CartService::class);
        $cartService->expects($this->once())
            ->method('addItem')
            ->with($item)
            ->willReturn(true);

        $controller = new CartController($cartService, $validator);
        $request = Request::create('/cart', 'POST', [], [], [], [], json_encode(['item' => $item]));

        $response = $controller->addToCart($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals(['message' => 'Item added to the cart.'], $responseData);
    }
}
