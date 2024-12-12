<?php

namespace App\Services;

use App\Jobs\ProcessOrderQueue;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Interfaces\ConcessionRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class OrderService
{
    private $orderRepository;
    private $concessionRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        ConcessionRepositoryInterface $concessionRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->concessionRepository = $concessionRepository;
    }

    public function getAllOrders()
    {
        return $this->orderRepository->getAllOrders(); // Use repository to get all orders
    }


    public function createOrder(array $data)
    {
        // Validate concessions exist and get their details
        $concessions = [];
        $totalCost = 0;
        
        foreach ($data['concessions'] as $concessionId => $quantity) {
            $concession = $this->concessionRepository->find($concessionId);
            if (!$concession) {
                throw new \Exception("Concession not found: {$concessionId}");
            }
            $concessions[$concessionId] = $quantity;
        }

        // Convert send_to_kitchen_time to Carbon instance
        $sendToKitchenTime = Carbon::parse($data['send_to_kitchen_time']);

        $orderData = [
            'send_to_kitchen_time' => $data['send_to_kitchen_time'],
            'concessions' => $concessions
        ];

        // Create order
        $order = $this->orderRepository->create($orderData);

        // Schedule order processing
        ProcessOrderQueue::dispatch($order)
            ->delay($order->send_to_kitchen_time);

        return $order;
    }

    public function sendOrderToKitchen(int $orderId)
    {
        $order = $this->orderRepository->findById($orderId);
        
        if (!$order) {
            throw new \Exception("Order not found");
        }

        // Update order status to In-Progress
        $this->orderRepository->updateOrderStatus($orderId, 'In-Progress');

        // Log the order processing
        Log::info("Order {$orderId} sent to kitchen manually");

        return $order;
    }

    public function getOrdersForKitchen()
    {
        return $this->orderRepository->getOrdersForKitchen();
    }

    public function updateOrderStatus(int $orderId, string $status)
    {
        return $this->orderRepository->updateOrderStatus($orderId, $status);
    }

    public function deleteOrder(int $orderId)
    {
        return $this->orderRepository->deleteOrder($orderId);
    }

}