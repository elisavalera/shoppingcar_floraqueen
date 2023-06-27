<?php

namespace App\Controller;

use App\Service\CartService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    private $cartService;
    private $validator;

    public function __construct(CartService $cartService, ValidatorInterface $validator)
    {
        $this->cartService = $cartService;
        $this->validator = $validator;
    }

    /**
     * @Route("/cart", name="add_to_cart", methods={"POST"})
     */
    public function addToCart(Request $request): JsonResponse
    {
        
        $requestData = json_decode($request->getContent(), true);

        if ($requestData === null) {
            return new JsonResponse(['error' => 'Invalid JSON payload.'], 400);
        }

        $items = $requestData['items'] ?? null;
        $responses = [];
        // Process each item and add it to the cart
        foreach ($items as $item) {
            // Validate the item parameter
            $errors = $this->validator->validate($item, new Assert\NotBlank());

            if (count($errors) > 0) {
                return new JsonResponse(['error' => 'Invalid item parameter.'], 400);
            }

            
            // Add the item to the cart
            if ($this->cartService->addItem($item)) {
                $responses[] = "Item $item added to the cart.";
            } else {
                return new JsonResponse(['error' => 'Failed to add item to the cart.'], 500);
            }
        }

        // Calculate the total amount and display it
        $totalAmount = $this->cartService->calculateTotalAmount();
        return new JsonResponse(['message' => $responses, 'total' =>sprintf('Total cart amount: %s', $totalAmount)]);
    }

    /**
     * @Route("/cart", name="get_cart", methods={"GET"})
     */
    public function getCart(): JsonResponse
    {
        // Retrieve the cart details
        $cart = $this->cartService->getCart();

        return new JsonResponse($cart);
    }

    /**
     * @Route("/cart/total", name="calculate_total_amount", methods={"GET"})
     */
    public function calculateTotalAmount(): JsonResponse
    {
        // Calculate the total amount
        $totalAmount = $this->cartService->calculateTotalAmount();

        return new JsonResponse(['total_amount' => $totalAmount]);
    }

    /**
     * @Route("/cart/clear", name="clear_cart", methods={"POST"})
     */
    public function clearCart(): JsonResponse
    {
        $this->cartService->clearCart();

        return new JsonResponse(['message' => 'Cart cleared.']);
    }
}
