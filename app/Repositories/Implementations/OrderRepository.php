<?php

namespace App\Repositories\Implementations;

use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderRepositoryInterface
{
    public function create(array $data): Order
    {
        return DB::transaction(function () use ($data) {
            $order = Order::create([
                'send_to_kitchen_time' => $data['send_to_kitchen_time'],
                'status' => 'Pending'
            ]);

            // Attach concessions with quantities
            $concessions = [];
            foreach ($data['concessions'] as $concessionId => $quantity) {
                $concessions[$concessionId] = ['quantity' => $quantity];
            }
            $order->concessions()->attach($concessions);

            // Calculate total cost
            $order->calculateTotalCost();

            return $order;
        });
    }

    public function findById(int $id): ?Order
    {
        return Order::with('concessions')->findOrFail($id);
    }

    public function getAllOrders(): Collection
    {
        return Order::with('concessions')->get();
    }

    public function deleteOrder(int $id): bool
    {
        $order = $this->findById($id);
        return $order ? $order->delete() : false;
    }

    public function getOrdersForKitchen(): Collection
    {
        return Order::whereIn('status', ['Pending', 'In-Progress'])
            ->with('concessions')
            ->orderBy('send_to_kitchen_time')
            ->get();
    }

    public function updateOrderStatus(int $orderId, string $status): bool
    {
        $order = $this->findById($orderId);
        if (!$order) {
            return false;
        }

        $order->status = $status;
        return $order->save();
    }
}