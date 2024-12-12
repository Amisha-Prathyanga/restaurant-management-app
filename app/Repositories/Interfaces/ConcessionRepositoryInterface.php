<?php
// app/Repositories/Interfaces/ConcessionRepositoryInterface.php
namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;
use App\Models\Concession;

interface ConcessionRepositoryInterface
{
    public function all(array $filters = []): Collection;
    public function find(int $id): ?Concession;
    public function create(array $data): Concession;
    public function update(int $id, array $data): Concession;
    public function delete(int $id): bool;
    public function restore(int $id): bool;
}