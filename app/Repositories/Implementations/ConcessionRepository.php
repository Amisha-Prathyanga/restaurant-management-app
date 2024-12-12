<?php
// app/Repositories/Implementations/ConcessionRepository.php
namespace App\Repositories\Implementations;

use App\Models\Concession;
use App\Repositories\Interfaces\ConcessionRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class ConcessionRepository implements ConcessionRepositoryInterface
{
    public function all(array $filters = []): Collection
    {
        $query = Concession::query();

        // Apply filters
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['min_price'])) {
            $query->where('price', '>=', $filters['min_price']);
        }

        if (!empty($filters['max_price'])) {
            $query->where('price', '<=', $filters['max_price']);
        }

        return $query->get();
    }

    public function find(int $id): ?Concession
    {
        return Concession::findOrFail($id);
    }

    public function create(array $data): Concession
    {
        // Handle image upload
        if (isset($data['image'])) {
            $data['image'] = $this->uploadImage($data['image']);
        }

        return Concession::create($data);
    }

    public function update(int $id, array $data): Concession
    {
        $concession = $this->find($id);

        // Handle image upload and delete old image
        if (isset($data['image'])) {
            // Delete old image if exists
            if ($concession->image) {
                Storage::delete($concession->image);
            }
            $data['image'] = $this->uploadImage($data['image']);
        }

        $concession->update($data);
        return $concession;
    }

    public function delete(int $id): bool
    {
        $concession = $this->find($id);
        return $concession->delete();
    }

    public function restore(int $id): bool
    {
        $concession = Concession::withTrashed()->findOrFail($id);
        return $concession->restore();
    }

    private function uploadImage($image): string
    {
        return $image->store('concessions', 'public');
    }
}