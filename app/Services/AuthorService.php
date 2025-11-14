<?php

namespace App\Services;

use App\Repositories\Interfaces\AuthorRepositoryInterface;
use App\Models\Author;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


class AuthorService
{
    public function __construct(
        protected AuthorRepositoryInterface $authorsRepository
    ) {}

    public function list(int $perPage = 10): LengthAwarePaginator
    {
        return $this->authorsRepository->paginate($perPage);
    }

    public function findOrFail(int $id): Author
    {
        $author = $this->authorsRepository->find($id);
        abort_if(!$author, 404, 'Author not found');
        return $author;
    }

    public function create(array $data): Author
    {
        return $this->authorsRepository->create($data);
    }

    public function update(int $id, array $data): Author
    {
        $author = $this->findOrFail($id);
        return $this->authorsRepository->update($author, $data);
    }

    public function delete(int $id): void
    {
        $author = $this->findOrFail($id);
        $this->authorsRepository->delete($author);
    }
}
