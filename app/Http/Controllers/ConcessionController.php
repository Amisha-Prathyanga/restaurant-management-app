<?php
// app/Http/Controllers/ConcessionController.php
namespace App\Http\Controllers;

use App\Services\ConcessionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ConcessionController extends Controller
{
    private $concessionService;

    public function __construct(ConcessionService $concessionService)
    {
        $this->concessionService = $concessionService;
    }

    public function index(Request $request)
    {
        try {
            $filters = $request->only(['status', 'min_price', 'max_price']);
            $concessions = $this->concessionService->getAllConcessions($filters);
            
            return view('concessions.index', compact('concessions'));
        } catch (\Exception $e) {
            Log::error('Error fetching concessions: ' . $e->getMessage());
            return back()->with('error', 'Unable to fetch concessions');
        }
    }

    public function create()
    {
        return view('concessions.create');
    }


    public function store(Request $request)
    {
        try {
            $concession = $this->concessionService->createConcession($request->all());
            
            return redirect()
                ->route('concessions.index')
                ->with('success', 'Concession created successfully');
        } catch (\InvalidArgumentException $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Error creating concession: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Failed to create concession');
        }
    }

    public function edit($id)
    {
        try {
            $concession = $this->concessionService->getConcession($id);
            return view('concessions.edit', compact('concession'));
        } catch (\Exception $e) {
            Log::error('Error fetching concession: ' . $e->getMessage());
            return back()->with('error', 'Concession not found');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $concession = $this->concessionService->updateConcession($id, $request->all());
            
            return redirect()
                ->route('concessions.index')
                ->with('success', 'Concession updated successfully');
        } catch (\InvalidArgumentException $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Error updating concession: ' . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Failed to update concession');
        }
    }

    public function destroy($id)
    {
        try {
            $this->concessionService->deleteConcession($id);
            
            return redirect()
                ->route('concessions.index')
                ->with('success', 'Concession deleted successfully');
        } catch (\Exception $e) {
            Log::error('Error deleting concession: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete concession');
        }
    }
}