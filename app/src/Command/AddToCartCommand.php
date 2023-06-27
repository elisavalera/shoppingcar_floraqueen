<?php

namespace App\Command;

use App\Service\CartService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddToCartCommand extends Command
{
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('cart:add')
            ->setDescription('Add products and vouchers to the cart and calculate the total amount')
            ->addArgument('items', InputArgument::IS_ARRAY, 'List of items (products and vouchers) to add to the cart');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $items = $input->getArgument('items');

        // Process each item and add it to the cart
        foreach ($items as $item) {
            if ($this->cartService->addItem($item)) {
                $output->writeln(sprintf('Item "%s" added to the cart.', $item));
            } else {
                $output->writeln(sprintf('Failed to add item "%s" to the cart.', $item));
            }
        }

        // Calculate the total amount and display it
        $totalAmount = $this->cartService->calculateTotalAmount();
        $output->writeln(sprintf('Total cart amount: %s', $totalAmount));

        return Command::SUCCESS;
    }
}
