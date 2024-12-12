<?php
// app/Services/ConcessionService.php
namespace App\Services;

use App\Repositories\Interfaces\ConcessionRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use App\Models\Concession;

class ConcessionService
{
    private $repository;

    public function __construct(ConcessionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllConcessions(array $filters = [])
    {
        return $this->repository->all($filters);
    }

    public function getConcession(int $id)
    {
        return $this->repository->find($id);
    }


    public function createConcession(array $data)
    {
        // Validate input
        $validator = Validator::make($data, Concession::rules());

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        return $this->repository->create($data);
    }

    public function updateConcession(int $id, array $data)
    {
        // Validate input
        $validator = Validator::make($data, Concession::rules($id));

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        return $this->repository->update($id, $data);
    }

    public function deleteConcession(int $id)
    {
        return $this->repository->delete($id);
    }
}