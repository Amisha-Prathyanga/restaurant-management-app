<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Repositories\Interfaces\ConcessionRepositoryInterface;
use App\Services\ConcessionService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderController extends Controller
{
    private $orderService;
    //private $concessionRepository;
    private $concessionService;

    public function __construct(
        OrderService $orderService,
        //ConcessionRepositoryInterface $concessionRepository
        ConcessionService $concessionService
    ) {
        $this->orderService = $orderService;
        //$this->concessionRepository = $concessionRepository;
        $this->concessionService = $concessionService;
    }

    public function index()
    {
        // $concessions = $this->concessionService->getAllConcessions();
        // return view('orders.index', compact('concessions'));

        $orders = $this->orderService->getAllOrders(); // Fetch all orders
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $concessions = $this->concessionService->getAllConcessions();
        return view('orders.create', compact('concessions'));
    }

    public function store(OrderRequest $request)
    {
        try {
            $validatedData = $request->validated();
        
            // Ensure send_to_kitchen_time is properly formatted
            $validatedData['send_to_kitchen_time'] = Carbon::parse($validatedData['send_to_kitchen_time']);
            
            $order = $this->orderService->createOrder($validatedData);
            //$order = $this->orderService->createOrder($request->validated());
            
            return redirect()
                ->route('orders.index')
                ->with('success', 'Order created successfully');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    public function kitchenView()
    {
        $orders = $this->orderService->getOrdersForKitchen();
        return view('kitchen.dashboard', compact('orders'));
    }

    public function updateStatus(Request $request, $orderId)
    {
        $validated = $request->validate([
            'status' => 'required|in:Pending,In-Progress,Completed'
        ]);

        try {
            $this->orderService->updateOrderStatus($orderId, $validated['status']);
            
            return response()->json([
                'success' => true, 
                'message' => 'Order status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function sendToKitchen($orderId)
    {
        try {
            $this->orderService->sendOrderToKitchen($orderId);
            
            return response()->json([
                'success' => true, 
                'message' => 'Order sent to kitchen successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function destroy($orderId)
    {
        try {
            // Call service to delete the order
            $this->orderService->deleteOrder($orderId);

            return redirect()->route('orders.index')
                ->with('success', 'Order deleted successfully');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

}