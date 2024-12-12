<?php

namespace App\Repositories\Interfaces;

use App\Models\Order;
use Illuminate\Support\Collection;

interface OrderRepositoryInterface
{
    public function create(array $data): Order;
    public function findById(int $id): ?Order;
    public function getAllOrders(): Collection;
    public function deleteOrder(int $id): bool;
    public function getOrdersForKitchen(): Collection;
    public function updateOrderStatus(int $orderId, string $status): bool;
}