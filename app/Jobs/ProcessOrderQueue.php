<?php

namespace App\Jobs;

use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessOrderQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new job instance.
     *
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @param OrderRepositoryInterface $orderRepository
     * @return void
     */
    public function handle(OrderRepositoryInterface $orderRepository)
    {
        try {
            // Check if order still exists and is in Pending status
            $order = $orderRepository->findById($this->order->id);
            
            if (!$order || $order->status !== 'Pending') {
                Log::info("Order {$this->order->id} cannot be processed. Might be already handled.");
                return;
            }

            // Update order status to In-Progress
            $orderRepository->updateOrderStatus($order->id, 'In-Progress');

            // Log the order processing
            Log::info("Order {$order->id} automatically sent to kitchen at " . now());
        } catch (\Exception $e) {
            // Log any errors during processing
            Log::error("Error processing order {$this->order->id}: " . $e->getMessage());
            
            // Optionally, you can choose to release the job back to the queue
            $this->release(10);
        }
    }

    /**
     * Handle a job failure.
     *
     * @param \Throwable $exception
     * @return void
     */
    public function failed(\Throwable $exception)
    {
        Log::error("Job failed for order {$this->order->id}: " . $exception->getMessage());
    }
}